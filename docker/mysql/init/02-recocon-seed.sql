-- RecoCon demonstration seed data (MySQL 8.0)
-- Run only after schema.sql in an EMPTY development database.
-- All people, contact details and reservations below are fictional.
-- DO NOT import this file into the production database.
-- Demo login: recocon_demo / RecoConDemo2026!
-- Demo staff: recocon_staff / RecoConDemo2026!
-- Change demo credentials or remove demo accounts if exposed beyond local development.
SET NAMES utf8mb4;
START TRANSACTION;

-- Discs: preserve source titles and image filenames; replace descriptions with original demo copy.
INSERT INTO `Disc` (`d_id`, `d_title`, `d_detail`, `d_path`) VALUES
(1, 'J.S.バッハ：平均律クラビーア曲集第１巻、第２巻（抜粋）他
ケンプ（Pf）', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'bach_kempff.jpg'),
(2, 'ベートーヴェン：ピアノソナタ第30、31、32番
グード', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'beethoven_goode.jpg'),
(3, 'ブラームス：交響曲第1番
他
フルトヴェングラー = BPO', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'brahms_furtwangler.jpg'),
(4, 'ショパン：前奏曲全集
2つの夜想曲作品62
ブレハッチ（ピアノ）', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'chopin_blechacz.jpg'),
(5, 'ドビュッシー：前奏曲集
エマール', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'debussy_aimard.jpg'),
(6, 'マーラー：交響曲第9番
アバド/BPO', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'mahler_abbado.jpg'),
(7, 'モーツァルト：後期6大交響曲集
ベーム', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'mozart_bohm.jpg'),
(8, 'モーツァルト：ピアノ協奏曲第20番・第21番 他
ピリス', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'mozart_pires.jpg'),
(9, '夕暮れの情景〜シューベルト歌曲集
ゲルハーヘル', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'schubert_gerhaher.jpg'),
(10, 'シューマン：
ダヴィッド同盟舞曲集、幻想曲
内田光子', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'schumann_mitsuko.jpg'),
(11, 'THE ART OF SEGOVIA', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'segovia.jpg'),
(12, 'グレゴリアン・チャント', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'canto_gregoriano.jpg'),
(13, 'メシアン：トゥーランガリラ交響曲', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'messiaen_chung.jpg'),
(14, 'シェーンベルク:浄められた夜、他', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'schenberg_mitropoulos.jpg'),
(15, 'ホルスト:組曲<惑星>/グレインジャー:戦士たち', 'レコードコンサートのデモ用アルバム紹介です。演奏作品や座席予約の操作をお試しください。', 'holst_planets.jpg');

-- Future demo concert dates; preserve concert IDs for existing application logic.
INSERT INTO `Concert_Schedule` (`cs_id`, `cs_date`, `cs_open`, `cs_start`, `cs_composer_en`, `cs_title_en`, `cs_composer_jn`, `cs_title_jn`, `d_id`) VALUES
(1, '2026-12-12', '14:00:00', '14:30:00', 'J.S.Bach', 'The Well-Tempered Clavier', 'バッハ', '平均律クラヴィーア曲集第1巻', 1),
(2, '2027-01-09', '14:00:00', '14:30:00', 'L.v.Beethoven', 'Piano Sonata No.32 in C minor', 'ベートーヴェン', 'ピアノソナタ第32番', 2),
(3, '2027-02-06', '14:00:00', '14:30:00', 'W.A.Mozart', 'Symphonie No. 41 in C major', 'モーツァルト', '交響曲第41番', 7),
(4, '2027-03-06', '18:00:00', '18:30:00', 'F.Schubert', 'Abendbilder, Am Fenster ...etc', 'シューベルト', '夕暮れの情景、窓辺で', 9),
(5, '2027-04-03', '14:00:00', '14:30:00', 'J.Brahms', 'Symphony No.1 in C minor', 'ブラームス', '交響曲第1番', 3),
(6, '2027-05-01', '14:00:00', '14:30:00', 'W.A.Mozart', 'Piano Concerto No.20 in D minor', 'モーツァルト', 'ピアノ協奏曲第20番', 8),
(7, '2027-05-29', '14:00:00', '14:30:00', 'G.Mahler', 'Symphony No. 9 in D major', 'マーラー', '交響曲第9番', 6),
(8, '2027-06-26', '14:00:00', '14:30:00', 'F.Chopin', '24 Preludes', 'ショパン', '24の前奏曲', 4),
(9, '2027-07-24', '14:00:00', '14:30:00', 'C.Debussy', 'Preludes', 'ドビュッシー', '前奏曲集第1巻', 5),
(10, '2027-08-21', '14:00:00', '14:30:00', 'R.Schumann', 'Fantasie in C major', 'シューマン', '幻想曲', 10),
(11, '2027-09-18', '14:00:00', '14:30:00', 'SEGOVIA', 'THE ART OF SEGOVIA ', 'セゴビア', 'セゴビアの芸術', 11),
(12, '2027-10-16', '14:00:00', '14:30:00', 'Coro De Monjes Del Monasterio', 'CANTO GREGORIANO', 'シロス修道院 修道会', 'グレゴリアン・チャント', 12),
(13, '2027-11-13', '14:00:00', '14:30:00', 'O.Mesiaen', 'Turangalila-Symphinie', 'メシアン', 'トゥーランガリラ交響曲', 13),
(14, '2027-12-11', '14:00:00', '14:30:00', 'A.Schoenberg', 'Transfigured Night', 'シェーンベルク', '清められた夜', 14),
(15, '2028-01-08', '14:00:00', '14:30:00', 'G.Holst', 'The Planets', 'ホルスト', '惑星', 15);

INSERT INTO `Ticket` (`seat`, `price`, `tax`, `price_tax`) VALUES
('A-1', 500, 10, 550),
('A-2', 500, 10, 550),
('A-3', 500, 10, 550),
('B-1', 500, 10, 550),
('B-2', 500, 10, 550),
('B-3', 500, 10, 550),
('C-1', 500, 10, 550),
('C-2', 500, 10, 550),
('C-3', 500, 10, 550),
('D-1', 500, 10, 550),
('D-2', 500, 10, 550),
('D-3', 500, 10, 550);

-- All contacts are deliberately non-deliverable example.com addresses and fictional numbers.
INSERT INTO `User` (`u_id`, `u_name`, `u_age`, `u_sex`, `u_address_1`, `u_address_2`, `u_address_3`, `u_tel`, `u_mail`, `u_input_id`, `u_input_pass`) VALUES
(1, 'サンプル 太郎', 30, '男', '大阪府', '大阪市', 'サンプル町1-1', '000-0000-0000', 'demo-user@example.com', 'recocon_demo', '$argon2id$v=19$m=65536,t=4,p=1$ODZRSG5kNkFMaEowWWFRcg$VDNoiVuAXWY4yCiZFmnjsFu+X/nMBuE5Tr2WuhNdbTc'),
(2, 'サンプル 花子', 28, '女', '兵庫県', '神戸市', 'サンプル町2-2', '000-0000-0000', 'demo-user2@example.com', 'recocon_demo2', '$argon2id$v=19$m=65536,t=4,p=1$ODZRSG5kNkFMaEowWWFRcg$VDNoiVuAXWY4yCiZFmnjsFu+X/nMBuE5Tr2WuhNdbTc');

INSERT INTO `Staff` (`s_id`, `s_name`, `s_age`, `s_sex`, `s_address_1`, `s_address_2`, `s_address_3`, `s_tel`, `s_mail`, `s_input_id`, `s_input_pass`) VALUES
(1, 'デモ 管理者', 30, '男', '大阪府', '大阪市', 'サンプル町3-3', '000-0000-0000', 'demo-staff@example.com', 'recocon_staff', '$argon2id$v=19$m=65536,t=4,p=1$ODZRSG5kNkFMaEowWWFRcg$VDNoiVuAXWY4yCiZFmnjsFu+X/nMBuE5Tr2WuhNdbTc');

INSERT INTO `Guest` (`g_id`, `g_name`, `g_age`, `g_sex`, `g_address_1`, `g_address_2`, `g_address_3`, `g_tel`, `g_mail`) VALUES
(1, 'ゲスト 見本', 25, '女', '京都府', '京都市', 'サンプル町4-4', '000-0000-0000', 'demo-guest@example.com');

-- Each concert has exactly 12 seats. All unreserved seats have NULL owners.
-- First concert: mixed sales; second: sold out; remaining: all available.
INSERT INTO `Ticket_Sale` (`ts_id`, `cs_id`, `seat`, `sale`, `u_id`, `g_id`) VALUES
(1, 1, 'A-1', 1, 1, NULL),
(2, 1, 'A-2', 0, NULL, NULL),
(3, 1, 'A-3', 0, NULL, NULL),
(4, 1, 'B-1', 0, NULL, NULL),
(5, 1, 'B-2', 1, 1, NULL),
(6, 1, 'B-3', 0, NULL, NULL),
(7, 1, 'C-1', 0, NULL, NULL),
(8, 1, 'C-2', 0, NULL, NULL),
(9, 1, 'C-3', 1, NULL, 1),
(10, 1, 'D-1', 0, NULL, NULL),
(11, 1, 'D-2', 0, NULL, NULL),
(12, 1, 'D-3', 0, NULL, NULL),
(13, 2, 'A-1', 1, 1, NULL),
(14, 2, 'A-2', 1, 2, NULL),
(15, 2, 'A-3', 1, 2, NULL),
(16, 2, 'B-1', 1, 1, NULL),
(17, 2, 'B-2', 1, 2, NULL),
(18, 2, 'B-3', 1, 2, NULL),
(19, 2, 'C-1', 1, 1, NULL),
(20, 2, 'C-2', 1, 2, NULL),
(21, 2, 'C-3', 1, 2, NULL),
(22, 2, 'D-1', 1, 1, NULL),
(23, 2, 'D-2', 1, 2, NULL),
(24, 2, 'D-3', 1, 2, NULL),
(25, 3, 'A-1', 0, NULL, NULL),
(26, 3, 'A-2', 0, NULL, NULL),
(27, 3, 'A-3', 0, NULL, NULL),
(28, 3, 'B-1', 0, NULL, NULL),
(29, 3, 'B-2', 0, NULL, NULL),
(30, 3, 'B-3', 0, NULL, NULL),
(31, 3, 'C-1', 0, NULL, NULL),
(32, 3, 'C-2', 0, NULL, NULL),
(33, 3, 'C-3', 0, NULL, NULL),
(34, 3, 'D-1', 0, NULL, NULL),
(35, 3, 'D-2', 0, NULL, NULL),
(36, 3, 'D-3', 0, NULL, NULL),
(37, 4, 'A-1', 0, NULL, NULL),
(38, 4, 'A-2', 0, NULL, NULL),
(39, 4, 'A-3', 0, NULL, NULL),
(40, 4, 'B-1', 0, NULL, NULL),
(41, 4, 'B-2', 0, NULL, NULL),
(42, 4, 'B-3', 0, NULL, NULL),
(43, 4, 'C-1', 0, NULL, NULL),
(44, 4, 'C-2', 0, NULL, NULL),
(45, 4, 'C-3', 0, NULL, NULL),
(46, 4, 'D-1', 0, NULL, NULL),
(47, 4, 'D-2', 0, NULL, NULL),
(48, 4, 'D-3', 0, NULL, NULL),
(49, 5, 'A-1', 0, NULL, NULL),
(50, 5, 'A-2', 0, NULL, NULL),
(51, 5, 'A-3', 0, NULL, NULL),
(52, 5, 'B-1', 0, NULL, NULL),
(53, 5, 'B-2', 0, NULL, NULL),
(54, 5, 'B-3', 0, NULL, NULL),
(55, 5, 'C-1', 0, NULL, NULL),
(56, 5, 'C-2', 0, NULL, NULL),
(57, 5, 'C-3', 0, NULL, NULL),
(58, 5, 'D-1', 0, NULL, NULL),
(59, 5, 'D-2', 0, NULL, NULL),
(60, 5, 'D-3', 0, NULL, NULL),
(61, 6, 'A-1', 0, NULL, NULL),
(62, 6, 'A-2', 0, NULL, NULL),
(63, 6, 'A-3', 0, NULL, NULL),
(64, 6, 'B-1', 0, NULL, NULL),
(65, 6, 'B-2', 0, NULL, NULL),
(66, 6, 'B-3', 0, NULL, NULL),
(67, 6, 'C-1', 0, NULL, NULL),
(68, 6, 'C-2', 0, NULL, NULL),
(69, 6, 'C-3', 0, NULL, NULL),
(70, 6, 'D-1', 0, NULL, NULL),
(71, 6, 'D-2', 0, NULL, NULL),
(72, 6, 'D-3', 0, NULL, NULL),
(73, 7, 'A-1', 0, NULL, NULL),
(74, 7, 'A-2', 0, NULL, NULL),
(75, 7, 'A-3', 0, NULL, NULL),
(76, 7, 'B-1', 0, NULL, NULL),
(77, 7, 'B-2', 0, NULL, NULL),
(78, 7, 'B-3', 0, NULL, NULL),
(79, 7, 'C-1', 0, NULL, NULL),
(80, 7, 'C-2', 0, NULL, NULL),
(81, 7, 'C-3', 0, NULL, NULL),
(82, 7, 'D-1', 0, NULL, NULL),
(83, 7, 'D-2', 0, NULL, NULL),
(84, 7, 'D-3', 0, NULL, NULL),
(85, 8, 'A-1', 0, NULL, NULL),
(86, 8, 'A-2', 0, NULL, NULL),
(87, 8, 'A-3', 0, NULL, NULL),
(88, 8, 'B-1', 0, NULL, NULL),
(89, 8, 'B-2', 0, NULL, NULL),
(90, 8, 'B-3', 0, NULL, NULL),
(91, 8, 'C-1', 0, NULL, NULL),
(92, 8, 'C-2', 0, NULL, NULL),
(93, 8, 'C-3', 0, NULL, NULL),
(94, 8, 'D-1', 0, NULL, NULL),
(95, 8, 'D-2', 0, NULL, NULL),
(96, 8, 'D-3', 0, NULL, NULL),
(97, 9, 'A-1', 0, NULL, NULL),
(98, 9, 'A-2', 0, NULL, NULL),
(99, 9, 'A-3', 0, NULL, NULL),
(100, 9, 'B-1', 0, NULL, NULL),
(101, 9, 'B-2', 0, NULL, NULL),
(102, 9, 'B-3', 0, NULL, NULL),
(103, 9, 'C-1', 0, NULL, NULL),
(104, 9, 'C-2', 0, NULL, NULL),
(105, 9, 'C-3', 0, NULL, NULL),
(106, 9, 'D-1', 0, NULL, NULL),
(107, 9, 'D-2', 0, NULL, NULL),
(108, 9, 'D-3', 0, NULL, NULL),
(109, 10, 'A-1', 0, NULL, NULL),
(110, 10, 'A-2', 0, NULL, NULL),
(111, 10, 'A-3', 0, NULL, NULL),
(112, 10, 'B-1', 0, NULL, NULL),
(113, 10, 'B-2', 0, NULL, NULL),
(114, 10, 'B-3', 0, NULL, NULL),
(115, 10, 'C-1', 0, NULL, NULL),
(116, 10, 'C-2', 0, NULL, NULL),
(117, 10, 'C-3', 0, NULL, NULL),
(118, 10, 'D-1', 0, NULL, NULL),
(119, 10, 'D-2', 0, NULL, NULL),
(120, 10, 'D-3', 0, NULL, NULL),
(121, 11, 'A-1', 0, NULL, NULL),
(122, 11, 'A-2', 0, NULL, NULL),
(123, 11, 'A-3', 0, NULL, NULL),
(124, 11, 'B-1', 0, NULL, NULL),
(125, 11, 'B-2', 0, NULL, NULL),
(126, 11, 'B-3', 0, NULL, NULL),
(127, 11, 'C-1', 0, NULL, NULL),
(128, 11, 'C-2', 0, NULL, NULL),
(129, 11, 'C-3', 0, NULL, NULL),
(130, 11, 'D-1', 0, NULL, NULL),
(131, 11, 'D-2', 0, NULL, NULL),
(132, 11, 'D-3', 0, NULL, NULL),
(133, 12, 'A-1', 0, NULL, NULL),
(134, 12, 'A-2', 0, NULL, NULL),
(135, 12, 'A-3', 0, NULL, NULL),
(136, 12, 'B-1', 0, NULL, NULL),
(137, 12, 'B-2', 0, NULL, NULL),
(138, 12, 'B-3', 0, NULL, NULL),
(139, 12, 'C-1', 0, NULL, NULL),
(140, 12, 'C-2', 0, NULL, NULL),
(141, 12, 'C-3', 0, NULL, NULL),
(142, 12, 'D-1', 0, NULL, NULL),
(143, 12, 'D-2', 0, NULL, NULL),
(144, 12, 'D-3', 0, NULL, NULL),
(145, 13, 'A-1', 0, NULL, NULL),
(146, 13, 'A-2', 0, NULL, NULL),
(147, 13, 'A-3', 0, NULL, NULL),
(148, 13, 'B-1', 0, NULL, NULL),
(149, 13, 'B-2', 0, NULL, NULL),
(150, 13, 'B-3', 0, NULL, NULL),
(151, 13, 'C-1', 0, NULL, NULL),
(152, 13, 'C-2', 0, NULL, NULL),
(153, 13, 'C-3', 0, NULL, NULL),
(154, 13, 'D-1', 0, NULL, NULL),
(155, 13, 'D-2', 0, NULL, NULL),
(156, 13, 'D-3', 0, NULL, NULL),
(157, 14, 'A-1', 0, NULL, NULL),
(158, 14, 'A-2', 0, NULL, NULL),
(159, 14, 'A-3', 0, NULL, NULL),
(160, 14, 'B-1', 0, NULL, NULL),
(161, 14, 'B-2', 0, NULL, NULL),
(162, 14, 'B-3', 0, NULL, NULL),
(163, 14, 'C-1', 0, NULL, NULL),
(164, 14, 'C-2', 0, NULL, NULL),
(165, 14, 'C-3', 0, NULL, NULL),
(166, 14, 'D-1', 0, NULL, NULL),
(167, 14, 'D-2', 0, NULL, NULL),
(168, 14, 'D-3', 0, NULL, NULL),
(169, 15, 'A-1', 0, NULL, NULL),
(170, 15, 'A-2', 0, NULL, NULL),
(171, 15, 'A-3', 0, NULL, NULL),
(172, 15, 'B-1', 0, NULL, NULL),
(173, 15, 'B-2', 0, NULL, NULL),
(174, 15, 'B-3', 0, NULL, NULL),
(175, 15, 'C-1', 0, NULL, NULL),
(176, 15, 'C-2', 0, NULL, NULL),
(177, 15, 'C-3', 0, NULL, NULL),
(178, 15, 'D-1', 0, NULL, NULL),
(179, 15, 'D-2', 0, NULL, NULL),
(180, 15, 'D-3', 0, NULL, NULL);

INSERT INTO `News` (`n_id`, `n_date`, `news`) VALUES
(1, '2026-11-24', 'RecoConのデモ環境へようこそ。公演情報や座席予約をお試しください。'),
(2, '2026-11-24', 'このサイトの公演・予約情報は動作確認用のサンプルです。');

INSERT INTO `Request` (`r_id`, `r_date`, `u_id`, `request`, `answer`) VALUES
(1, '2026-11-24', 1, '次回のレコードコンサートも楽しみにしています。', 'ありがとうございます。開催予定をご確認ください。');

-- Login_Failed intentionally starts empty.
COMMIT;
