<?php

    function recoconLoginWithLimit(
        PDO $pdo,
        string $loginId,
        string $password,
        $user,
        string $ip
    ): string {

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return 'busy';
        }

        $idHash = hash('sha256', $loginId);

        //同じ接続元ID・IPの同時認証をロックで制御
        $locks = [
            'rc:id:' . substr($idHash, 0, 56),
            'rc:ip:' . substr(hash('sha256', $ip), 0, 56)
        ];

        sort($locks, SORT_STRING);   //デッドロック対策の順番制御。
        $held = [];   //ロック中のIDとIP登録用配列。

        try {
            $getLock = $pdo->prepare(
                'SELECT GET_LOCK(:id_ip, 3)'   //最大3秒待ち。
            );
            foreach ($locks as $id_ip) {
                $getLock->execute([':id_ip' => $id_ip]);   //ロック実行。
                $locked = $getLock->fetchColumn();         //結果を取得。1:完了 0:取得失敗 null:エラーなど
                $getLock->closeCursor();                   //foreachで繰り返すので初期化をはさむ。ロック開放ではない！
                if ((string)$locked !== '1') {
                    return 'busy';
                }
                $held[] = $id_ip;
            }

            //直近15分のID別失敗回数。
            $stmt = $pdo->prepare(
                'SELECT COUNT(*) FROM Login_Failed
                 WHERE login_id_hash = UNHEX(:idHash)
                 AND datetime_at >= NOW() - INTERVAL 15 MINUTE'
            );
            $stmt->execute([':idHash' => $idHash]);
            $idFailures = (int)$stmt->fetchColumn();
            $stmt->closeCursor();

            //直近15分のIP別失敗回数。
            $stmt = $pdo->prepare(
                'SELECT COUNT(*) FROM Login_Failed
                 WHERE ip_address = :ip
                 AND datetime_at >= NOW() - INTERVAL 15 MINUTE'
            );
            $stmt->execute([':ip' => $ip]);
            $ipFailures = (int)$stmt->fetchColumn();
            $stmt->closeCursor();
            if ($idFailures >= 5 || $ipFailures >= 30) {
                return 'limited';
            }

            //既存のパスワード照合
            $valid = is_array($user)
                && $loginId !== ''
                && $password !== ''
                && isset($user['u_input_pass'])
                && password_verify(
                    $password,
                    $user['u_input_pass']
                );

            if ($valid) {
                $result = 'ok';
            } else {
                $stmt = $pdo->prepare(
                    'INSERT INTO Login_Failed
                     (login_id_hash, ip_address)
                     VALUES (UNHEX(:idHash), :ip)'
                );
                $stmt->execute([
                    ':idHash' => $idHash,
                    ':ip' => $ip
                ]);
                $result = 'invalid';
            }

            //古い履歴を徐々に整理
            if (random_int(1, 100) === 1) {
                $stmtDelete = $pdo->prepare(
                    'DELETE FROM Login_Failed
                     WHERE datetime_at < NOW() - INTERVAL 1 DAY'
                );
                $stmtDelete -> execute();
            }

            return $result;

        } finally {
            //取得したロックを解放
            foreach (array_reverse($held) as $id_ip) {
                $stmt = $pdo->prepare(
                    'SELECT RELEASE_LOCK(:id_ip)'
                );
                $stmt->execute(['id_ip' => $id_ip]);
                $stmt->closeCursor();
            }
        }
    }
?>
