-- MySQL dump 10.13  Distrib 9.3.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: dekranasda
-- ------------------------------------------------------
-- Server version	9.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `beritas`
--

DROP TABLE IF EXISTS `beritas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beritas` (
  `berita_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ringkasan` text COLLATE utf8mb4_unicode_ci,
  `isi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `views` bigint unsigned NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`berita_id`),
  UNIQUE KEY `beritas_slug_unique` (`slug`),
  KEY `beritas_user_id_foreign` (`user_id`),
  CONSTRAINT `beritas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beritas`
--

LOCK TABLES `beritas` WRITE;
/*!40000 ALTER TABLE `beritas` DISABLE KEYS */;
INSERT INTO `beritas` VALUES (1,1,'Pemkab Tuban Gelar GPM Serentak di Seluruh Kecamatan, Sediakan 16 Ton Beras SPHP','pemkab-tuban-gelar-gpm-serentak-di-seluruh-kecamatan-sediakan-16-ton-beras-sphp-1786695727',NULL,'<p class=\"ql-align-justify\"><strong style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\"><em>Tubankab</em></strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">&nbsp;&nbsp;– Pemerintah Kabupaten Tuban menggelar Gerakan Pangan Murah (GPM) secara serentak di seluruh kantor kecamatan se-Kabupaten Tuban. Kegiatan yang menjadi bagian dari rangkaian peringatan Hari Kemerdekaan Republik Indonesia tersebut merupakan bentuk kehadiran pemerintah dalam membantu masyarakat memperoleh kebutuhan pangan dengan harga terjangkau.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Kepala Dinas Ketahanan Pangan, Pertanian dan Perikanan (DKP2P) Kabupaten Tuban, Eko Julianto, mengatakan GPM tidak sekadar menjadi kegiatan penyediaan pangan dengan harga murah. Lebih dari itu, GPM merupakan salah satu instrumen intervensi pemerintah untuk menjaga keterjangkauan pangan sekaligus stabilitas pasokan dan harga di tingkat masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“GPM ini menjadi bentuk kehadiran pemerintah untuk membantu masyarakat mendapatkan pangan dengan harga yang lebih terjangkau. Momentum Hari Kemerdekaan juga kita manfaatkan untuk memperkuat semangat kebersamaan dan gotong royong,” ungkapnya, Jumat (14/8).</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Menurut Eko, pelaksanaan GPM menjadi semakin penting karena menyediakan pangan dengan harga lebih terjangkau dibandingkan harga pasar. Dengan demikian, daya beli masyarakat diharapkan tetap terjaga.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“Harapannya masyarakat bisa mendapatkan kebutuhan pangan pokok dengan harga yang terjangkau. Di sisi lain, kegiatan ini juga menjadi bagian dari upaya menjaga stabilitas harga dan pasokan pangan serta mendukung pengendalian inflasi,” jelasnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Dalam pelaksanaan GPM kali ini, Pemkab Tuban menyediakan beras SPHP sebanyak 16.000 kilogram atau 16 ton, minyak goreng sebanyak 1.920 liter, serta gula pasir sebanyak 1.000 kilogram. Pemilihan ketiga komoditas tersebut mempertimbangkan tingginya kebutuhan masyarakat serta perannya dalam pengeluaran rumah tangga.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“Beras, gula, dan minyak goreng merupakan kebutuhan pokok yang hampir selalu dibeli masyarakat. Karena itu, intervensi terhadap tiga komoditas ini diharapkan memberikan manfaat yang bisa langsung dirasakan, terutama dalam menjaga daya beli masyarakat,” terangnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Selain menjadi kebutuhan pokok, ketiga komoditas tersebut juga termasuk pangan strategis yang menjadi perhatian dalam upaya pengendalian harga. Karena itu, fokus pada komoditas strategis dinilai lebih efektif dalam pelaksanaan GPM sehingga manfaat intervensi dapat dirasakan secara optimal oleh masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Pemilihan komoditas juga disesuaikan dengan ketersediaan stok, harga pengadaan, kemampuan distribusi, serta volume pangan yang dapat disediakan. Dengan pertimbangan tersebut, pangan yang disalurkan melalui GPM dapat diberikan dengan harga yang lebih terjangkau.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Mantan Camat Semanding ini menambahkan, pemilihan tiga komoditas tersebut bukan berarti pangan lainnya tidak penting. Namun, beras, gula, dan minyak goreng diprioritaskan karena memiliki tingkat kebutuhan yang tinggi dan menjadi bagian dari kebutuhan dasar masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“GPM ini bukan sekadar menjual pangan murah. Ini merupakan bagian dari intervensi pemerintah untuk menjaga keterjangkauan pangan, daya beli masyarakat, sekaligus membantu menjaga stabilitas harga,” tegasnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Melalui pelaksanaan GPM di seluruh kecamatan, Pemkab Tuban berharap masyarakat semakin mudah memperoleh pangan pokok berkualitas dengan harga terjangkau. Kegiatan ini sekaligus menjadi wujud pelayanan pemerintah kepada masyarakat dalam momentum peringatan Hari Kemerdekaan.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Pemkab Tuban berkomitmen untuk terus memperkuat upaya menjaga ketahanan pangan, stabilitas pasokan dan harga, serta memastikan kebutuhan pangan masyarakat dapat terpenuhi dengan baik.&nbsp;</span><strong style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">(ags/yav)</strong></p><p><br></p>','berita-cover/AUfr6NonmJLHUIA5iLIrf8ty9raFxcRAkSqoLHPk.png','published',5,NULL,'2026-08-14 01:22:07','2026-08-17 19:46:35'),(2,1,'Berita 2','berita-2-1786695740',NULL,'<p class=\"ql-align-justify\"><strong style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\"><em>Tubankab</em></strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">&nbsp;&nbsp;– Pemerintah Kabupaten Tuban menggelar Gerakan Pangan Murah (GPM) secara serentak di seluruh kantor kecamatan se-Kabupaten Tuban. Kegiatan yang menjadi bagian dari rangkaian peringatan Hari Kemerdekaan Republik Indonesia tersebut merupakan bentuk kehadiran pemerintah dalam membantu masyarakat memperoleh kebutuhan pangan dengan harga terjangkau.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Kepala Dinas Ketahanan Pangan, Pertanian dan Perikanan (DKP2P) Kabupaten Tuban, Eko Julianto, mengatakan GPM tidak sekadar menjadi kegiatan penyediaan pangan dengan harga murah. Lebih dari itu, GPM merupakan salah satu instrumen intervensi pemerintah untuk menjaga keterjangkauan pangan sekaligus stabilitas pasokan dan harga di tingkat masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“GPM ini menjadi bentuk kehadiran pemerintah untuk membantu masyarakat mendapatkan pangan dengan harga yang lebih terjangkau. Momentum Hari Kemerdekaan juga kita manfaatkan untuk memperkuat semangat kebersamaan dan gotong royong,” ungkapnya, Jumat (14/8).</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Menurut Eko, pelaksanaan GPM menjadi semakin penting karena menyediakan pangan dengan harga lebih terjangkau dibandingkan harga pasar. Dengan demikian, daya beli masyarakat diharapkan tetap terjaga.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“Harapannya masyarakat bisa mendapatkan kebutuhan pangan pokok dengan harga yang terjangkau. Di sisi lain, kegiatan ini juga menjadi bagian dari upaya menjaga stabilitas harga dan pasokan pangan serta mendukung pengendalian inflasi,” jelasnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Dalam pelaksanaan GPM kali ini, Pemkab Tuban menyediakan beras SPHP sebanyak 16.000 kilogram atau 16 ton, minyak goreng sebanyak 1.920 liter, serta gula pasir sebanyak 1.000 kilogram. Pemilihan ketiga komoditas tersebut mempertimbangkan tingginya kebutuhan masyarakat serta perannya dalam pengeluaran rumah tangga.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“Beras, gula, dan minyak goreng merupakan kebutuhan pokok yang hampir selalu dibeli masyarakat. Karena itu, intervensi terhadap tiga komoditas ini diharapkan memberikan manfaat yang bisa langsung dirasakan, terutama dalam menjaga daya beli masyarakat,” terangnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Selain menjadi kebutuhan pokok, ketiga komoditas tersebut juga termasuk pangan strategis yang menjadi perhatian dalam upaya pengendalian harga. Karena itu, fokus pada komoditas strategis dinilai lebih efektif dalam pelaksanaan GPM sehingga manfaat intervensi dapat dirasakan secara optimal oleh masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Pemilihan komoditas juga disesuaikan dengan ketersediaan stok, harga pengadaan, kemampuan distribusi, serta volume pangan yang dapat disediakan. Dengan pertimbangan tersebut, pangan yang disalurkan melalui GPM dapat diberikan dengan harga yang lebih terjangkau.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Mantan Camat Semanding ini menambahkan, pemilihan tiga komoditas tersebut bukan berarti pangan lainnya tidak penting. Namun, beras, gula, dan minyak goreng diprioritaskan karena memiliki tingkat kebutuhan yang tinggi dan menjadi bagian dari kebutuhan dasar masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“GPM ini bukan sekadar menjual pangan murah. Ini merupakan bagian dari intervensi pemerintah untuk menjaga keterjangkauan pangan, daya beli masyarakat, sekaligus membantu menjaga stabilitas harga,” tegasnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Melalui pelaksanaan GPM di seluruh kecamatan, Pemkab Tuban berharap masyarakat semakin mudah memperoleh pangan pokok berkualitas dengan harga terjangkau. Kegiatan ini sekaligus menjadi wujud pelayanan pemerintah kepada masyarakat dalam momentum peringatan Hari Kemerdekaan.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Pemkab Tuban berkomitmen untuk terus memperkuat upaya menjaga ketahanan pangan, stabilitas pasokan dan harga, serta memastikan kebutuhan pangan masyarakat dapat terpenuhi dengan baik.&nbsp;</span><strong style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">(ags/yav)</strong></p><p><br></p>','berita-cover/lEXziUz16STXOwh1qofvnLwmx3Mmebj1BdUSiN7k.png','published',1,NULL,'2026-08-14 01:22:20','2026-08-17 19:44:08'),(3,1,'Berita 3','berita-3-1786695756',NULL,'<p class=\"ql-align-justify\"><strong style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\"><em>Tubankab</em></strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">&nbsp;&nbsp;– Pemerintah Kabupaten Tuban menggelar Gerakan Pangan Murah (GPM) secara serentak di seluruh kantor kecamatan se-Kabupaten Tuban. Kegiatan yang menjadi bagian dari rangkaian peringatan Hari Kemerdekaan Republik Indonesia tersebut merupakan bentuk kehadiran pemerintah dalam membantu masyarakat memperoleh kebutuhan pangan dengan harga terjangkau.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Kepala Dinas Ketahanan Pangan, Pertanian dan Perikanan (DKP2P) Kabupaten Tuban, Eko Julianto, mengatakan GPM tidak sekadar menjadi kegiatan penyediaan pangan dengan harga murah. Lebih dari itu, GPM merupakan salah satu instrumen intervensi pemerintah untuk menjaga keterjangkauan pangan sekaligus stabilitas pasokan dan harga di tingkat masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“GPM ini menjadi bentuk kehadiran pemerintah untuk membantu masyarakat mendapatkan pangan dengan harga yang lebih terjangkau. Momentum Hari Kemerdekaan juga kita manfaatkan untuk memperkuat semangat kebersamaan dan gotong royong,” ungkapnya, Jumat (14/8).</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Menurut Eko, pelaksanaan GPM menjadi semakin penting karena menyediakan pangan dengan harga lebih terjangkau dibandingkan harga pasar. Dengan demikian, daya beli masyarakat diharapkan tetap terjaga.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“Harapannya masyarakat bisa mendapatkan kebutuhan pangan pokok dengan harga yang terjangkau. Di sisi lain, kegiatan ini juga menjadi bagian dari upaya menjaga stabilitas harga dan pasokan pangan serta mendukung pengendalian inflasi,” jelasnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Dalam pelaksanaan GPM kali ini, Pemkab Tuban menyediakan beras SPHP sebanyak 16.000 kilogram atau 16 ton, minyak goreng sebanyak 1.920 liter, serta gula pasir sebanyak 1.000 kilogram. Pemilihan ketiga komoditas tersebut mempertimbangkan tingginya kebutuhan masyarakat serta perannya dalam pengeluaran rumah tangga.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“Beras, gula, dan minyak goreng merupakan kebutuhan pokok yang hampir selalu dibeli masyarakat. Karena itu, intervensi terhadap tiga komoditas ini diharapkan memberikan manfaat yang bisa langsung dirasakan, terutama dalam menjaga daya beli masyarakat,” terangnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Selain menjadi kebutuhan pokok, ketiga komoditas tersebut juga termasuk pangan strategis yang menjadi perhatian dalam upaya pengendalian harga. Karena itu, fokus pada komoditas strategis dinilai lebih efektif dalam pelaksanaan GPM sehingga manfaat intervensi dapat dirasakan secara optimal oleh masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Pemilihan komoditas juga disesuaikan dengan ketersediaan stok, harga pengadaan, kemampuan distribusi, serta volume pangan yang dapat disediakan. Dengan pertimbangan tersebut, pangan yang disalurkan melalui GPM dapat diberikan dengan harga yang lebih terjangkau.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Mantan Camat Semanding ini menambahkan, pemilihan tiga komoditas tersebut bukan berarti pangan lainnya tidak penting. Namun, beras, gula, dan minyak goreng diprioritaskan karena memiliki tingkat kebutuhan yang tinggi dan menjadi bagian dari kebutuhan dasar masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“GPM ini bukan sekadar menjual pangan murah. Ini merupakan bagian dari intervensi pemerintah untuk menjaga keterjangkauan pangan, daya beli masyarakat, sekaligus membantu menjaga stabilitas harga,” tegasnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Melalui pelaksanaan GPM di seluruh kecamatan, Pemkab Tuban berharap masyarakat semakin mudah memperoleh pangan pokok berkualitas dengan harga terjangkau. Kegiatan ini sekaligus menjadi wujud pelayanan pemerintah kepada masyarakat dalam momentum peringatan Hari Kemerdekaan.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Pemkab Tuban berkomitmen untuk terus memperkuat upaya menjaga ketahanan pangan, stabilitas pasokan dan harga, serta memastikan kebutuhan pangan masyarakat dapat terpenuhi dengan baik.&nbsp;</span><strong style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">(ags/yav)</strong></p><p><br></p>','berita-cover/1ij3CiQnQEG0CfWufLisrTh1kSAaHakPqvENVPNn.png','published',30,NULL,'2026-08-14 01:22:36','2026-08-17 19:43:37'),(4,1,'Berita 4','berita-4-1786696062',NULL,'<p class=\"ql-align-justify\"><strong style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\"><em>Tubankab</em></strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">&nbsp;&nbsp;– Pemerintah Kabupaten Tuban menggelar Gerakan Pangan Murah (GPM) secara serentak di seluruh kantor kecamatan se-Kabupaten Tuban. Kegiatan yang menjadi bagian dari rangkaian peringatan Hari Kemerdekaan Republik Indonesia tersebut merupakan bentuk kehadiran pemerintah dalam membantu masyarakat memperoleh kebutuhan pangan dengan harga terjangkau.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Kepala Dinas Ketahanan Pangan, Pertanian dan Perikanan (DKP2P) Kabupaten Tuban, Eko Julianto, mengatakan GPM tidak sekadar menjadi kegiatan penyediaan pangan dengan harga murah. Lebih dari itu, GPM merupakan salah satu instrumen intervensi pemerintah untuk menjaga keterjangkauan pangan sekaligus stabilitas pasokan dan harga di tingkat masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“GPM ini menjadi bentuk kehadiran pemerintah untuk membantu masyarakat mendapatkan pangan dengan harga yang lebih terjangkau. Momentum Hari Kemerdekaan juga kita manfaatkan untuk memperkuat semangat kebersamaan dan gotong royong,” ungkapnya, Jumat (14/8).</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Menurut Eko, pelaksanaan GPM menjadi semakin penting karena menyediakan pangan dengan harga lebih terjangkau dibandingkan harga pasar. Dengan demikian, daya beli masyarakat diharapkan tetap terjaga.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“Harapannya masyarakat bisa mendapatkan kebutuhan pangan pokok dengan harga yang terjangkau. Di sisi lain, kegiatan ini juga menjadi bagian dari upaya menjaga stabilitas harga dan pasokan pangan serta mendukung pengendalian inflasi,” jelasnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Dalam pelaksanaan GPM kali ini, Pemkab Tuban menyediakan beras SPHP sebanyak 16.000 kilogram atau 16 ton, minyak goreng sebanyak 1.920 liter, serta gula pasir sebanyak 1.000 kilogram. Pemilihan ketiga komoditas tersebut mempertimbangkan tingginya kebutuhan masyarakat serta perannya dalam pengeluaran rumah tangga.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“Beras, gula, dan minyak goreng merupakan kebutuhan pokok yang hampir selalu dibeli masyarakat. Karena itu, intervensi terhadap tiga komoditas ini diharapkan memberikan manfaat yang bisa langsung dirasakan, terutama dalam menjaga daya beli masyarakat,” terangnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Selain menjadi kebutuhan pokok, ketiga komoditas tersebut juga termasuk pangan strategis yang menjadi perhatian dalam upaya pengendalian harga. Karena itu, fokus pada komoditas strategis dinilai lebih efektif dalam pelaksanaan GPM sehingga manfaat intervensi dapat dirasakan secara optimal oleh masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Pemilihan komoditas juga disesuaikan dengan ketersediaan stok, harga pengadaan, kemampuan distribusi, serta volume pangan yang dapat disediakan. Dengan pertimbangan tersebut, pangan yang disalurkan melalui GPM dapat diberikan dengan harga yang lebih terjangkau.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Mantan Camat Semanding ini menambahkan, pemilihan tiga komoditas tersebut bukan berarti pangan lainnya tidak penting. Namun, beras, gula, dan minyak goreng diprioritaskan karena memiliki tingkat kebutuhan yang tinggi dan menjadi bagian dari kebutuhan dasar masyarakat.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">“GPM ini bukan sekadar menjual pangan murah. Ini merupakan bagian dari intervensi pemerintah untuk menjaga keterjangkauan pangan, daya beli masyarakat, sekaligus membantu menjaga stabilitas harga,” tegasnya.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Melalui pelaksanaan GPM di seluruh kecamatan, Pemkab Tuban berharap masyarakat semakin mudah memperoleh pangan pokok berkualitas dengan harga terjangkau. Kegiatan ini sekaligus menjadi wujud pelayanan pemerintah kepada masyarakat dalam momentum peringatan Hari Kemerdekaan.</span></p><p class=\"ql-align-justify\"><span style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">Pemkab Tuban berkomitmen untuk terus memperkuat upaya menjaga ketahanan pangan, stabilitas pasokan dan harga, serta memastikan kebutuhan pangan masyarakat dapat terpenuhi dengan baik.&nbsp;</span><strong style=\"background-color: rgb(255, 255, 255); color: rgb(68, 68, 68);\">(ags/yav)</strong></p><p><br></p>','berita-cover/xNLDYAwSvqgi7USYa5799KyxnM6MU17cc1ziVw3E.png','published',1,NULL,'2026-08-14 01:27:42','2026-08-17 19:44:02');
/*!40000 ALTER TABLE `beritas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foto`
--

DROP TABLE IF EXISTS `foto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `foto` (
  `foto_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`foto_id`),
  UNIQUE KEY `foto_slug_unique` (`slug`),
  KEY `foto_user_id_foreign` (`user_id`),
  CONSTRAINT `foto_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foto`
--

LOCK TABLES `foto` WRITE;
/*!40000 ALTER TABLE `foto` DISABLE KEYS */;
/*!40000 ALTER TABLE `foto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kalender_kegiatan`
--

DROP TABLE IF EXISTS `kalender_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kalender_kegiatan` (
  `kegiatan_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penyelenggara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('mendatang','berlangsung','selesai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mendatang',
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kegiatan_id`),
  UNIQUE KEY `kalender_kegiatan_slug_unique` (`slug`),
  KEY `kalender_kegiatan_user_id_foreign` (`user_id`),
  CONSTRAINT `kalender_kegiatan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kalender_kegiatan`
--

LOCK TABLES `kalender_kegiatan` WRITE;
/*!40000 ALTER TABLE `kalender_kegiatan` DISABLE KEYS */;
INSERT INTO `kalender_kegiatan` VALUES (1,'Rapat koordinasi UMKM','rapat-koordinasi-umkm-1786683046','Kegiatan mengumpulkan UMKM','2026-08-19','2026-08-22','11:50:00','11:50:00','Gedung Pejuang','Diskopumdag','mendatang',1,'2026-08-13 21:50:46','2026-08-17 18:56:22'),(2,'Rapat koordinasi UMKM 2','rapat-koordinasi-umkm-2-1786683388','UMKM 2','2026-08-24','2026-08-25','11:56:00','11:56:00','Gedung Pejuang 2','Diskopumdag 2','mendatang',1,'2026-08-13 21:56:28','2026-08-17 18:56:13'),(3,'Pameran Kemerdekaan 81 Seni tidak akan pernah mari','pameran-kemerdekaan-81-seni-tidak-akan-pernah-mari-1787018598','Deskripsi kegiatan ini','2026-08-22','2026-08-29','09:03:00','13:03:00','Budaya Loka','Disbudporapar','mendatang',1,'2026-08-17 19:03:18','2026-08-17 19:03:18');
/*!40000 ALTER TABLE `kalender_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategoris`
--

DROP TABLE IF EXISTS `kategoris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategoris` (
  `kategori_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kategori_id`),
  UNIQUE KEY `kategoris_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategoris`
--

LOCK TABLES `kategoris` WRITE;
/*!40000 ALTER TABLE `kategoris` DISABLE KEYS */;
INSERT INTO `kategoris` VALUES (2,'Batik','batik','Batik kain','2026-08-12 23:19:05','2026-08-12 23:19:05'),(3,'Ukir Kayu','ukir-kayu','Ukir','2026-08-12 23:19:14','2026-08-12 23:19:14');
/*!40000 ALTER TABLE `kategoris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_11_055345_create_beritas_table',1),(5,'2026_08_11_080324_create_kalender_kegiatans_table',1),(6,'2026_08_11_091507_create_fotos_table',1),(7,'2026_08_12_032008_create_videos_table',1),(8,'2026_08_12_040106_create_umkms_table',1),(9,'2026_08_12_082022_create_produks_table',2),(10,'2026_08_13_012414_create_profils_table',3),(11,'2026_08_13_054409_create_kategoris_table',4),(12,'2026_08_14_030125_create_sliders_table',5),(13,'2026_08_15_201554_create_visitors_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produks`
--

DROP TABLE IF EXISTS `produks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produks` (
  `produk_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `umkm_id` bigint unsigned NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `foto_produk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('available','out_of_stock') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`produk_id`),
  KEY `produks_umkm_id_foreign` (`umkm_id`),
  CONSTRAINT `produks_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm` (`umkm_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produks`
--

LOCK TABLES `produks` WRITE;
/*!40000 ALTER TABLE `produks` DISABLE KEYS */;
INSERT INTO `produks` VALUES (5,1,'TV 211','tv-211',10000.00,'Baju','[\"produk\\/XA0TlGAc8xZ01EVjbl45RQdZtvipWYDPUOZGGUGE.png\",\"produk\\/gQHuRaXgGTgCn9JtKuAxIS78xy5hg2pB19DaFZH5.png\",\"produk\\/0gGhiK5QEFT0DRyDLzgxB2bLpkMNZHx3VmjmrRty.png\",\"produk\\/dTz08Zw4ICiK3dpaosE9oGHoM5WvdIBzn3FeiwNC.png\"]','available','2026-08-13 19:20:03','2026-08-15 19:19:06','3','9'),(6,3,'Kulkas','kulkas',12000000.00,'Kulkas 2 pintu adem dan nyaman','[\"produk\\/DJpQALjakB2cxaTpFjLy9c0zoWBnBQM7rUKMoEzH.png\"]','available','2026-08-15 05:50:20','2026-08-15 19:17:25','3','2'),(7,1,'Mesin Cuci','mesin-cuci',2000000.00,'Mesin cuci 3 Tabung','[\"produk\\/VhTh2loBRRruG9IL0R1pjmqoDVRCgncDKquAJhTC.png\"]','available','2026-08-15 05:50:55','2026-08-18 19:17:22','2','3'),(8,3,'AC 29 PK','ac-29-pk',90000000.00,'Dapat meningkatkan tampilan dekoratif ruangan\r\nMudah dipasang di meja\r\nRangka kokoh, stabil, dan awet\r\nMenambah ruang untuk penyimpanan meja\r\nOrganizer pada papan dapat disusun sesuai keinginan\r\nCocok untuk menyimpan alat tulis, headphone, dan hiasan dekorasi\r\nIsi set : 1 pc papan pegboard, 2 pcs pen holder, 1pcs storage shelf, 1 pc cup holder, 5pcs pin magnet, 4 pcs hook, 1 pc headphone hook\r\nDaya beban maksimal : 10 kg\r\n\r\n\r\n===========================\r\n\r\nVar Warna Biru\r\n\r\nDapat meningkatkan tampilan dekoratif ruangan\r\nMudah dipasang di meja\r\nRangka kokoh, stabil, dan awet\r\nMenambah ruang untuk penyimpanan meja\r\nOrganizer pada papan dapat disusun sesuai keinginan\r\nCocok untuk menyimpan alat tulis, headphone, dan hiasan dekorasi\r\nIsi set : 1 pc papan pegboard, 2 pcs pen holder, 1pcs storage shelf, 1 pc cup holder, 5pcs pin magnet, 4 pcs hook, 1 pc headphone hook\r\nDaya beban maksimal : 10 kg\r\n\r\n===========================\r\n\r\nVar Warna Hitam\r\n\r\nIsi set : 1 pc papan pegboard, 2 pcs pen holder, 1 pcs storage shelf, 1 pc cup holder, 5 pcs pin magnet, 4 pcs hook, 1 pc headphone hook\r\n\r\n\r\n===========================\r\n\r\nVar Warna Putih\r\n\r\nDapat meningkatkan tampilan dekoratif ruangan\r\nMudah dipasang di meja\r\nRangka kokoh, stabil, dan awet\r\nMenambah ruang untuk penyimpanan meja\r\nOrganizer pada papan dapat disusun sesuai keinginan\r\nCocok untuk menyimpan alat tulis, headphone, dan hiasan dekorasi\r\nIsi set : 1 pc papan pegboard, 2 pcs pen holder, 1pcs storage shelf, 1 pc cup holder, 5pcs pin magnet, 4 pcs hook, 1 pc headphone hook\r\nDaya beban maksimal : 10 kg','[\"produk\\/7lfHE7QaZm7x7sDSzDteQMOM9MB9yNKTJGGO7jP5.png\"]','available','2026-08-15 05:51:23','2026-08-18 19:28:34','3','8');
/*!40000 ALTER TABLE `produks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profils`
--

DROP TABLE IF EXISTS `profils`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profils` (
  `profil_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `visi` text COLLATE utf8mb4_unicode_ci,
  `misi` text COLLATE utf8mb4_unicode_ci,
  `foto_struktur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_singkat` text COLLATE utf8mb4_unicode_ci,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_maps` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `instagram` text COLLATE utf8mb4_unicode_ci,
  `youtube` text COLLATE utf8mb4_unicode_ci,
  `foto_dekranasda` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`profil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profils`
--

LOCK TABLES `profils` WRITE;
/*!40000 ALTER TABLE `profils` DISABLE KEYS */;
INSERT INTO `profils` VALUES (1,'Visi Organisasi ini adalah','Misi organisasi ini adalah','profil/2agFoV7wf4fk4woeMHEenF1e1SYTW2Czd4IzDKrG.png',NULL,'Jl. DR. Wahidin Sudirohusodo No.117, Latsari, Kec. Tuban, Kabupaten Tuban, Jawa Timur 62314','081122334455','dekranasda@tubankab.go.id','https://maps.app.goo.gl/ag9ji8rxCf9nihRw8','2026-08-12 18:46:07','2026-08-15 06:25:47','https://www.instagram.com/dekranasda.tuban/','https://www.youtube.com/watch?v=r4XIHGiUC0c&t=1286s','profil/fVPaw8590gOolyIe7HR0NadUDfYlGE5pVrYuVFSf.png');
/*!40000 ALTER TABLE `profils` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `role_id` bigint NOT NULL AUTO_INCREMENT,
  `role_nama` varchar(100) DEFAULT NULL,
  `role_deskripsi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin',NULL),(2,'editor',NULL),(3,'umkm',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('7cxsQNSqajIp2DeLsp1qhqrh8SDk81gsF8DHKirG',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWloRXNGbGFWRk1EZjFvSkNSRHpjSGtpODI3djljY2VwckhuWDFVaSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Vta20iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FnZW5kYS1rZWdpYXRhbj9wYWdlPTEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1787101579),('PHLM7laLTEAspXsbNYxV0CA7lsXG1Ij9Tpe5cLUO',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVjhuUzkyRFRzQXZacDg1Um9oazBNZlg1RGdleTZDRGl6c3NLRWh5MiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYW5hamVtZW4tdXNlciI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1787108421),('WLNyORK6NMCBBnR6sMKVEYf8XCCanVupAlAT2k1N',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMk5HZkRHdVZGUVhLaE00dHJaTFJkN1ppTDBEeXF5dGtET1Z0NjFpSyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdW1rbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1787110223);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders` (
  `slider_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (2,'Hari Pramuka','Pramuka Hari ini','sliders/cILtGwwPZ4SnOmbtFUpAXBbjywJSnF3omOEUezYW.png',NULL,1,'active','2026-08-13 20:24:56','2026-08-13 20:58:58'),(3,'Kominfo','Konifo ini','sliders/fMbbwIwUcBN0xFYARxRHO6OBeuzEwHjocFoA1U6t.png',NULL,2,'active','2026-08-13 21:00:17','2026-08-13 21:00:17');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `umkm`
--

DROP TABLE IF EXISTS `umkm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `umkm` (
  `umkm_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_umkm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `foto_umkm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('published','terverifikasi','ditolak','menunggu','nonaktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`umkm_id`),
  UNIQUE KEY `umkm_slug_unique` (`slug`),
  KEY `umkm_user_id_foreign` (`user_id`),
  CONSTRAINT `umkm_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `umkm`
--

LOCK TABLES `umkm` WRITE;
/*!40000 ALTER TABLE `umkm` DISABLE KEYS */;
INSERT INTO `umkm` VALUES (1,'Jaya Baru Ini','jaya-baru-n2e03','Kuliner','Jl.Diponegoro ini','Ini deskripsi UMKM saya ini','umkm-logo/ECypoGzeNCDpc6apbqAoYH4wozzuuV5w01y1eJM5.png','terverifikasi',1,'2026-08-12 00:46:15','2026-08-12 21:01:55'),(3,'Barabesto','barabesto-69Xut','Kuliner','Alamat disini','Deskrpsi barabesto','umkm/omQU4rKx1vWzWZWL4dQHoFfBlHx2sXZ6Tx0W0dqn.jpg','terverifikasi',1,'2026-08-12 19:50:35','2026-08-12 19:50:35'),(5,'Fave','fave-sH1Xz',NULL,'Perumahan Mutiara Jaya 2','Usaha Penginapan','umkm/BNPgBQuKULDODBmjRBs7TqtpRNo4k9VqDs5H9LzA.png','nonaktif',8,'2026-08-18 19:38:17','2026-08-18 20:28:48');
/*!40000 ALTER TABLE `umkm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint DEFAULT NULL,
  `no_telp` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umkm_id` bigint DEFAULT NULL,
  `instagram` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Dekranasda','admin@dekranasda.test',NULL,'$2y$12$cEhqxhEtobUwEW8PVPYDY.U5dRs76iiN1VCZ2e0nl3HBFo9smVWY.',NULL,'2026-08-11 22:00:29','2026-08-12 19:08:58',1,'08899872772122','Tuban Akbar','terverifikasi','users/HZbZlvULcBmG5ASA1xrc6CuGNGE2RWRmiwTuAKFM.png',NULL,'@abc'),(4,'Debby Virgiawan Eko','debbyvekoptif@gmail.com',NULL,'$2y$12$Jcnnz637dhOjTEgRbsoV1elNu9LOWujnZK1jpl.fG7xgMsxwOqn9u',NULL,'2026-08-12 19:32:13','2026-08-12 21:02:34',3,'097072017099','Perumahan Mutiara Jaya','terverifikasi','foto-profil/hqdQdSvTO9eK5dClaKpxWu2mFtJAbq5eKjtYt8x0.png',1,'abc'),(5,'Junanobi','juna@gmail.com',NULL,'$2y$12$BH1cPtu64D8Y50SEzctV7uO8.eo.MwpK5Eu.r4efhlrPxUFi9TtFy',NULL,'2026-08-12 22:30:12','2026-08-12 22:30:12',2,'1111111122222','Plumpang Tuban Talun','terverifikasi','foto-profil/KMu1sNrwnLoymYzMxkZ3NWbygS6zEpMhwrfnJmsn.png',NULL,'junanobi'),(8,'Oman','ex.cekutor@gmail.com',NULL,'$2y$12$8W6KGVukemhdiayb1H86yO6IhsC1qjciPPoaV0mECFRIDSmv4aoWK',NULL,'2026-08-18 19:38:17','2026-08-18 20:28:48',3,'0987654321','Perumahan Mutiara Jaya 2','nonaktif','umkm/BNPgBQuKULDODBmjRBs7TqtpRNo4k9VqDs5H9LzA.png',5,'@fave');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video` (
  `video_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `url_youtube` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`video_id`),
  UNIQUE KEY `video_slug_unique` (`slug`),
  KEY `video_user_id_foreign` (`user_id`),
  CONSTRAINT `video_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video`
--

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `visitors_ip_address_visit_date_unique` (`ip_address`,`visit_date`)
) ENGINE=InnoDB AUTO_INCREMENT=656 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitors`
--

LOCK TABLES `visitors` WRITE;
/*!40000 ALTER TABLE `visitors` DISABLE KEYS */;
INSERT INTO `visitors` VALUES (1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','2026-08-15','2026-08-15 13:22:06','2026-08-15 13:22:06'),(40,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','2026-08-16','2026-08-15 17:27:52','2026-08-15 17:27:52'),(148,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.133.0 Chrome/148.0.7778.280 Electron/42.8.0 Safari/537.36','2026-08-18','2026-08-17 18:27:39','2026-08-17 18:27:39'),(442,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','2026-08-19','2026-08-18 18:06:17','2026-08-18 18:06:17');
/*!40000 ALTER TABLE `visitors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-19 10:32:52
