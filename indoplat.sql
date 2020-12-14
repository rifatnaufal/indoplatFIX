/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100414
 Source Host           : localhost:3306
 Source Schema         : indoplat

 Target Server Type    : MySQL
 Target Server Version : 100414
 File Encoding         : 65001

 Date: 05/12/2020 11:14:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mesin
-- ----------------------------
DROP TABLE IF EXISTS `mesin`;
CREATE TABLE `mesin`  (
  `kode_mesin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_mesin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `proses_mesin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mesin
-- ----------------------------
INSERT INTO `mesin` VALUES ('m-01', 'mesin A', 'proc-01');
INSERT INTO `mesin` VALUES ('m-02', 'mesin B', 'proc-01');
INSERT INTO `mesin` VALUES ('m-03', 'mesin C', 'proc-02');
INSERT INTO `mesin` VALUES ('m-04', 'mesin D', 'proc-02');
INSERT INTO `mesin` VALUES ('m-05', 'mesin E', 'proc-03');
INSERT INTO `mesin` VALUES ('m-06', 'mesin F', 'proc-03');
INSERT INTO `mesin` VALUES ('m-07', 'mesin G', 'proc-04');
INSERT INTO `mesin` VALUES ('m-08', 'mesin H', 'proc-04');
INSERT INTO `mesin` VALUES ('m-09', 'mesin I', 'proc-05');
INSERT INTO `mesin` VALUES ('m-10', 'mesin J', 'proc-05');
INSERT INTO `mesin` VALUES ('m-11', 'mesin K', 'proc-06');
INSERT INTO `mesin` VALUES ('m-12', 'mesin L', 'proc-06');

-- ----------------------------
-- Table structure for mps
-- ----------------------------
DROP TABLE IF EXISTS `mps`;
CREATE TABLE `mps`  (
  `kode_pesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `proses_terlibat` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `load_proses` int(4) NULL DEFAULT NULL,
  `tgl_pengerjaan` date NULL DEFAULT NULL,
  `kode_mesin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_pengerjaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `shift` smallint(1) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mps
-- ----------------------------
INSERT INTO `mps` VALUES ('pes-1', 'proc-01', 840, '2020-12-04', 'm-01', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-1', 'proc-02', 100, '2020-12-04', 'm-03', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-1', 'proc-03', 200, '2020-12-04', 'm-05', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-1', 'proc-01', 0, '2020-12-05', 'm-01', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-1', 'proc-02', 840, '2020-12-05', 'm-03', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-1', 'proc-03', 100, '2020-12-05', 'm-05', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-1', 'proc-01', 0, '2020-12-07', 'm-01', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-1', 'proc-02', 0, '2020-12-07', 'm-03', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-1', 'proc-03', 840, '2020-12-07', 'm-05', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-01', 840, '2020-12-04', 'm-02', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-02', 100, '2020-12-04', 'm-04', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-03', 200, '2020-12-04', 'm-06', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-01', 0, '2020-12-05', 'm-02', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-02', 840, '2020-12-05', 'm-04', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-03', 100, '2020-12-05', 'm-06', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-01', 0, '2020-12-07', 'm-02', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-02', 0, '2020-12-07', 'm-04', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-2', 'proc-03', 840, '2020-12-07', 'm-06', 'on process', 1);
INSERT INTO `mps` VALUES ('pes-3', 'proc-01', 960, '2020-12-04', 'm-01', 'on process', 2);
INSERT INTO `mps` VALUES ('pes-3', 'proc-02', 200, '2020-12-04', 'm-03', 'on process', 2);
INSERT INTO `mps` VALUES ('pes-3', 'proc-01', 0, '2020-12-05', 'm-01', 'on process', 2);
INSERT INTO `mps` VALUES ('pes-3', 'proc-02', 960, '2020-12-05', 'm-03', 'on process', 2);

-- ----------------------------
-- Table structure for pesanan
-- ----------------------------
DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan`  (
  `kode_pesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pemesan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_pesanan` bigint(20) NOT NULL,
  `banyak_pengiriman` int(5) NOT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`kode_pesanan`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pesanan
-- ----------------------------
INSERT INTO `pesanan` VALUES ('pes-1', 'Naufal Zayn M', 'afs', 1000, 2, 'on process');
INSERT INTO `pesanan` VALUES ('pes-2', 'Naufal Zayn M', 'afs', 1000, 2, 'on process');
INSERT INTO `pesanan` VALUES ('pes-3', 'lantang nirwana', 'wf', 1000, 2, 'on process');

-- ----------------------------
-- Table structure for proses
-- ----------------------------
DROP TABLE IF EXISTS `proses`;
CREATE TABLE `proses`  (
  `kode_proses` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_proses` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stok_wip` bigint(10) NOT NULL,
  PRIMARY KEY (`kode_proses`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of proses
-- ----------------------------
INSERT INTO `proses` VALUES ('proc-01', 'Injection', 100);
INSERT INTO `proses` VALUES ('proc-02', 'Finishing', 100);
INSERT INTO `proses` VALUES ('proc-03', 'Plating', 100);
INSERT INTO `proses` VALUES ('proc-04', 'QC', 100);
INSERT INTO `proses` VALUES ('proc-05', 'Double Tape', 100);
INSERT INTO `proses` VALUES ('proc-06', 'Sub-Assy', 100);

-- ----------------------------
-- Table structure for proses_pesanan
-- ----------------------------
DROP TABLE IF EXISTS `proses_pesanan`;
CREATE TABLE `proses_pesanan`  (
  `kode_pesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_proses` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  INDEX `kode_pesanan`(`kode_pesanan`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of proses_pesanan
-- ----------------------------
INSERT INTO `proses_pesanan` VALUES ('pes-1', 'proc-01');
INSERT INTO `proses_pesanan` VALUES ('pes-1', 'proc-02');
INSERT INTO `proses_pesanan` VALUES ('pes-1', 'proc-03');
INSERT INTO `proses_pesanan` VALUES ('pes-2', 'proc-01');
INSERT INTO `proses_pesanan` VALUES ('pes-2', 'proc-02');
INSERT INTO `proses_pesanan` VALUES ('pes-2', 'proc-03');
INSERT INTO `proses_pesanan` VALUES ('pes-3', 'proc-01');
INSERT INTO `proses_pesanan` VALUES ('pes-3', 'proc-02');

-- ----------------------------
-- Table structure for tgl_kirim_pesanan
-- ----------------------------
DROP TABLE IF EXISTS `tgl_kirim_pesanan`;
CREATE TABLE `tgl_kirim_pesanan`  (
  `kode_pesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_kirim` date NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tgl_kirim_pesanan
-- ----------------------------
INSERT INTO `tgl_kirim_pesanan` VALUES ('pes-1', '2020-12-11');
INSERT INTO `tgl_kirim_pesanan` VALUES ('pes-1', '2020-12-21');
INSERT INTO `tgl_kirim_pesanan` VALUES ('pes-2', '2020-12-11');
INSERT INTO `tgl_kirim_pesanan` VALUES ('pes-2', '2020-12-21');
INSERT INTO `tgl_kirim_pesanan` VALUES ('pes-3', '2020-12-11');
INSERT INTO `tgl_kirim_pesanan` VALUES ('pes-3', '2020-12-21');

SET FOREIGN_KEY_CHECKS = 1;
