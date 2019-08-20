/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100316
 Source Host           : localhost:3306
 Source Schema         : db_erp

 Target Server Type    : MySQL
 Target Server Version : 100316
 File Encoding         : 65001

 Date: 20/08/2019 23:35:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_barang
-- ----------------------------
DROP TABLE IF EXISTS `m_barang`;
CREATE TABLE `m_barang`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_satuan` int(10) NULL DEFAULT NULL,
  `id_jenis` int(10) NULL DEFAULT NULL,
  `nama_produk` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ukuran` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `satuan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_barang
-- ----------------------------
INSERT INTO `m_barang` VALUES (1, NULL, NULL, 'fwfw', '22', 'F', 4500);
INSERT INTO `m_barang` VALUES (2, NULL, NULL, 'bfbdfg', '22', 'hh', 800);
INSERT INTO `m_barang` VALUES (3, NULL, NULL, 'ETERT', '34', 'TR', 800);

-- ----------------------------
-- Table structure for m_customer
-- ----------------------------
DROP TABLE IF EXISTS `m_customer`;
CREATE TABLE `m_customer`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kode_pelanggan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telp` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_customer
-- ----------------------------
INSERT INTO `m_customer` VALUES (1, '238Y4234', 'Joni Iskandar', 'Jl.Nangka', '0218493538', 'joni_iskandar@gmail.com');

-- ----------------------------
-- Table structure for m_jabatan
-- ----------------------------
DROP TABLE IF EXISTS `m_jabatan`;
CREATE TABLE `m_jabatan`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_jabatan
-- ----------------------------
INSERT INTO `m_jabatan` VALUES (1, 'IT Head Dept');
INSERT INTO `m_jabatan` VALUES (3, 'HR Manager');
INSERT INTO `m_jabatan` VALUES (5, 'PPIC Staff');

-- ----------------------------
-- Table structure for m_jenis
-- ----------------------------
DROP TABLE IF EXISTS `m_jenis`;
CREATE TABLE `m_jenis`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_jenis
-- ----------------------------
INSERT INTO `m_jenis` VALUES (2, 'Basah');
INSERT INTO `m_jenis` VALUES (3, 'Kering');
INSERT INTO `m_jenis` VALUES (4, 'Padat');

-- ----------------------------
-- Table structure for m_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `m_karyawan`;
CREATE TABLE `m_karyawan`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nip` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `telp` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_jabatan` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_karyawan
-- ----------------------------
INSERT INTO `m_karyawan` VALUES (2, '8324', 'Tarmizi', 'Jl. Buaran', '02194783457', 'mi@mail.com', 1);
INSERT INTO `m_karyawan` VALUES (5, '728342', 'Kasino Sanwani', 'Jl.Naga', '0218473543', 'sanwani_kasino@gmail.com', 5);

-- ----------------------------
-- Table structure for m_material
-- ----------------------------
DROP TABLE IF EXISTS `m_material`;
CREATE TABLE `m_material`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_material` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_material` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_satuan` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_material
-- ----------------------------
INSERT INTO `m_material` VALUES (2, '234A', 'EW', 4);

-- ----------------------------
-- Table structure for m_produk
-- ----------------------------
DROP TABLE IF EXISTS `m_produk`;
CREATE TABLE `m_produk`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis` int(10) NULL DEFAULT NULL,
  `id_satuan` int(10) NULL DEFAULT NULL,
  `nama_produk` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ukuran` int(10) NULL DEFAULT NULL,
  `harga_satuan` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_produk
-- ----------------------------
INSERT INTO `m_produk` VALUES (4, 2, 2, 'Mie Instan', 100, 2000);
INSERT INTO `m_produk` VALUES (6, 3, 4, 'Marie Regal', 200, 4000);

-- ----------------------------
-- Table structure for m_satuan
-- ----------------------------
DROP TABLE IF EXISTS `m_satuan`;
CREATE TABLE `m_satuan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_satuan
-- ----------------------------
INSERT INTO `m_satuan` VALUES (1, 'Pcs');
INSERT INTO `m_satuan` VALUES (2, 'Inch');
INSERT INTO `m_satuan` VALUES (3, 'Item');
INSERT INTO `m_satuan` VALUES (4, 'mm');

-- ----------------------------
-- Table structure for m_user
-- ----------------------------
DROP TABLE IF EXISTS `m_user`;
CREATE TABLE `m_user`  (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_karyawan` int(10) NULL DEFAULT NULL,
  `level` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_user
-- ----------------------------
INSERT INTO `m_user` VALUES (1, 'admin', 'YQ==', NULL, NULL);
INSERT INTO `m_user` VALUES (10, 'sanwani', 'YQ==', 5, 3);

-- ----------------------------
-- Table structure for t_material
-- ----------------------------
DROP TABLE IF EXISTS `t_material`;
CREATE TABLE `t_material`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_so` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_material` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_material` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_satuan` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_so
-- ----------------------------
DROP TABLE IF EXISTS `t_so`;
CREATE TABLE `t_so`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_customer` int(10) NULL DEFAULT NULL,
  `no_so` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_sj` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_spk` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(10) NULL DEFAULT NULL COMMENT '1 create\r\n2 approve\r\n3 reject\r\n4 pending\r\n5 process\r\n6 finishing \r\n7 package',
  `date_assign` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_so_detail
-- ----------------------------
DROP TABLE IF EXISTS `t_so_detail`;
CREATE TABLE `t_so_detail`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `no_so` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_produk` int(10) NULL DEFAULT NULL,
  `qty` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_so_detail
-- ----------------------------
INSERT INTO `t_so_detail` VALUES (3, '201908200000001', 6, 5);

SET FOREIGN_KEY_CHECKS = 1;
