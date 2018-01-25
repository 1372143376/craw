/*
Navicat MySQL Data Transfer

Source Server         : localhost3306
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2018-01-25 09:45:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dede_quanquan
-- ----------------------------
DROP TABLE IF EXISTS `dede_quanquan`;
CREATE TABLE `dede_quanquan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `wx` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_done` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dede_quanquan
-- ----------------------------
INSERT INTO `dede_quanquan` VALUES ('1', '凯胜出国移民', 'cansine ', '130', 'https://mp.weixin.qq.com/s?timestamp=1514251178&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX7jBfK2uJuYWBuai*R21Cxr4pV4U7IfXkVtUbdj*jrW-RsfmkPRNsVIa3IKhm*K4gdkEuQ0Xu8SQACPc4DwWBcBUbmKm14JxgqlvOyPAA*TS8Po6Gh-gy3AIjVEr5SyVRr0rqplWUJNWLjouE7ujudk=', '1');
INSERT INTO `dede_quanquan` VALUES ('2', '侨外移民', 'qiaowaigroup ', '133', 'https://mp.weixin.qq.com/s?timestamp=1514252059&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX*CspKjBSG4bHwcZtx--bkHu0dfRT6ZEElsCNEgjK2pjdgZhAI0K6EXdNZgahYKTz2aebr29LbGbeeJD21HlTq9y1pwad9C*vLcNCUM3L6Xd4c1eEO*sH26sjYhLCMMlrQhWJ4g*YnfjMaLzuR3tlj4=', '1');
INSERT INTO `dede_quanquan` VALUES ('3', '东力移民留学', 'dongli-group ', ' 32 ', 'https://mp.weixin.qq.com/s?timestamp=1514252492&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX038BP0aTzCLnnsL52QCdfoJIO6vdtqtKsKSneIGyWe*ua8FtAFYLHPfoJaTH4bQUPEw3Ck7Uj7ZP-EfVn7nu3-jV*xB7G52HxwYc1D1vQZxk6k4LjMEg4NkvHWIUaV7H81L3BQwj9V4yfSLQo5DIk4=', '1');
INSERT INTO `dede_quanquan` VALUES ('4', '杰圣移民', 'goodyimin ', '89', 'https://mp.weixin.qq.com/s?timestamp=1514253263&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX6qmf8LJegmFYE1Yw-OWoCnka-ekdbbAcEV5dwjaikZxcnj1ivVNOafqNYrtXP6IBGaIIoyB*0ADdBB3uGo0ITfa3-DfyM9l4SFgOe8PCmq8t9HPXZ9l*M3n7wbs3Pj*X2CtNeD5-3*gQPPZfIHNOZ0=', '1');
INSERT INTO `dede_quanquan` VALUES ('5', '环球移民英国移民', 'globevisa_UK', '66', 'https://mp.weixin.qq.com/s?timestamp=1514253550&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX6NRoy2UdexoldLg2nqhP*NAe*ROdvbZleeOmfF3reMe-sweDDn*BI*81dYn1jBmuyRjH-z--8X8*ZhtdR1bt6OUVqinTZzTsH2PACfzWcMkjoXRVd-FF8dW3opoYFwLby5CRFz2RTHb1LpCEBgoiXs=', '1');
INSERT INTO `dede_quanquan` VALUES ('6', '凌宇澳洲移民', 'aozhouyiminly ', '113', 'https://mp.weixin.qq.com/s?timestamp=1514253761&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX1BziS227e4OCgqs-C-gQvmQH9Vwi962fKMjkG4xvVXwj0kDnIBwXXASlHfitPx8xmLFu4hHxE3sjkHpCpz5vm-CK7jbPoPmb1vS6cKAZ0JFq0jbpXJTFVV*fxarKIVSo3JmdBX4qsf0b9CQ5-ZCU0M=', '1');
INSERT INTO `dede_quanquan` VALUES ('7', '荣耀移民留学', 'glorygroup ', '42', 'https://mp.weixin.qq.com/s?timestamp=1514254191&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX8qvDEdduAOC56t-GL*OmEKg1PoAyPU8wNMyv2p4UWOTQGT78RClRVglKp3wDtZFe7Ah9G0muEVlExOIREVVTwAgl-CA3Zxq8fTvomZe8hLG6nZgdy-IELUZpi-NDX1MF9LC-fsRz0w4ya5RNZu4Uvg=', '1');
INSERT INTO `dede_quanquan` VALUES ('8', '丰诚留学移民', 'gh_4dfb1d9e8a0f ', '3', 'https://mp.weixin.qq.com/s?timestamp=1514254387&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX*aFqNNyT97LIbB52SWaqnym6EyJGdGD48gofCctKEhffMQEiTPsfvtM9vt0KczFmiKahDhN1TxwsJY8hh3m6ErJ88iW3kMyv4hLVQZk8TYlNLGgaxaGmM3e1rmsZIggHOFF1zHplNMXEwsjsslq1qg=', '1');
INSERT INTO `dede_quanquan` VALUES ('9', '捷旅移民留学', 'jieluchuguo-88483002 ', '8', 'https://mp.weixin.qq.com/s?timestamp=1514254570&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX*BLdo8gXudjDlRVphH8LZajrM1GQY73r5UgpD1NCytQ1RcN7iRpV-VXCeZSpZQRBK69c3hSeeKYG6VBDRIF7A68KVmY7Sk6IdLmp2l03vTuRhNF8n6w-xGqzfEZzvOzrklcm6x2lMVljUsu*jxbeOA=', '1');
INSERT INTO `dede_quanquan` VALUES ('10', '凌宇移民', 'skymigration ', '135', 'https://mp.weixin.qq.com/s?__biz=MjM5MzI2MjQ4MA==&mid=2652026844&idx=3&sn=08dda12ca73fee4584c9ddcfb5223a33&chksm=bd7fa9238a082035e6b69157a5bb83e7ae604b4d7de5fea78681b7fbe73a1e1fa06ee1bb0356&scene=27#wechat_redirect', '1');
INSERT INTO `dede_quanquan` VALUES ('11', '津桥移民', 'jinqiaoyimin ', '77', 'https://mp.weixin.qq.com/s?timestamp=1514255006&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX7R61RqXLSEwLBMV3mnYnILFfNpZ2VLJPHmF4MKbmzfjeS3BFfnNdJKzqGGu3wVoJZPniIhunnN*gu4ihwNfqBD6WqO5So9T1MYT2I4o3fkjLIVUEnsdnyVgc5FqbFyOgQBX2czL6hPOtHA1DBxKntw=', '1');
INSERT INTO `dede_quanquan` VALUES ('12', '兆龙移民', 'zhaolongyimin ', '107', 'https://mp.weixin.qq.com/s?timestamp=1514255186&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX-T3JpEdm-yZ7MeWaV8WCZLqVQfsVo-8yQir*YpMZzP0yKEcDiKH41XjeFjHH4xPQqqcBTF0uoPkCQB0dTEtFT5BJdyuxQkPM6D-VM9HlqFx1Wm9ElJZ3YkcmWIxVJw9wRKjS*eHriRGyeUkpuOUYwY=', '1');
INSERT INTO `dede_quanquan` VALUES ('13', '银河移民', 'galaxyimmi ', '76', 'https://mp.weixin.qq.com/s?timestamp=1514255552&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX93vYJ0JSNxciI4gt7sBigBdUUKmea7LmynnrrwXrMUWMIIqBzB9k4CTh6tKkY*g0frVwULzTqo131YvDl5FkMgnfBU9iETrU0UNapML9ARDn6vnp*3t-wJLGdTsX1x*so1B-RjM*G4huibVIl79IC4=', '1');
INSERT INTO `dede_quanquan` VALUES ('14', '旭飞移民', 'escxf1993 ', '32', 'https://mp.weixin.qq.com/s?timestamp=1514255698&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMXwyiMo9h5tWtv-zT9y-uNgPFqZ7GOSef-dkJC8FCPqN-9qxm85-Ae6Q4FQhoYZVas6BSA1dXp7iiOgSCpBOguSFJjjk8ry7eBx1HygX-vG4XEDxUwgdzDPVg1aRsfJLPtTrBeqAnvvdqyM55Z9scPxM=', '1');
INSERT INTO `dede_quanquan` VALUES ('15', '上外移民', 'swyimin ', '37', 'https://mp.weixin.qq.com/s?timestamp=1514255937&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX1Top-hNmWlXBOJIPLKHd7W*TsvKOb66raCQvOUtxWDb1H7WbNVGTSwuCm73Q76B59AcEliJBa4YI78ITSHqPD7EH8fn2W2WJG2TQnUAITOFePw6A6FFhsmSvbFMjju3-DPYaD0XpIyDKbAAq91NLng=', '1');
INSERT INTO `dede_quanquan` VALUES ('16', '皇家移民', 'RoyalWay4007006541 ', '130', 'https://mp.weixin.qq.com/s?timestamp=1514256099&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMXyoo-VfAQP3-Lh0FI*dtQ-zwen*gx49hVMVrmD6NDHD1yydVRIbrkk0*yZmp42sMuqPk0Q0eFKSfWpoE0PEXPOdvTASXpPKFFLftvxOoomzJI9YRXNO*4Ry63VpfefKsZ*wEaoQ67e3AznIoML-LTW0=', '1');
INSERT INTO `dede_quanquan` VALUES ('17', '诺华移民', 'novavisa ', '96', 'https://mp.weixin.qq.com/s?timestamp=1514256270&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX*6slMzgYtTCXOhfrD6BxoIV2Zpjz5XJhwGxd5hK9zfFVRZhl249VX9ZWBlL96u1Taud3zyM15OwW8W*Zp0fL1RewPA5UVDC798K9cRBcdYxznuCm0NwOJDGPimAF0UxZGHVkvG1cAe9zYBuxqVw*nQ=', '1');
INSERT INTO `dede_quanquan` VALUES ('18', '中智移民', 'zhongzhiyimin_sh ', '26', 'https://mp.weixin.qq.com/s?timestamp=1514256413&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX*30xT3n1mQ0*SeYGwOc*92zytyKmorCblTyGe*YYdXpyk9tsJWVVMgtpER82x2t9cP7JeQbO*eO26U1y1A8wFBPcgzs2St-CzoBjli66dmpNObkeD0-Itxkk4LZjdVanFdBDxcslSVOtnGZ1vZriKY=', '1');
INSERT INTO `dede_quanquan` VALUES ('19', '移民专栏', 'HKimmgration ', '4', 'https://mp.weixin.qq.com/s?timestamp=1514256682&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX0W-qesDTYLlACPO-x1vu890HS7Iq08fNjo0SjyQPQ0XztTYuKHCDBTXEO2Bt87UYlP15ZCZxbg**VLQ4WssQ6qDuv0-A4DwIoFXq4XoL1-53F5BDtoPExSITPaageFEMgCboWJH29IJpCGT7kRS*Jo=', '1');
INSERT INTO `dede_quanquan` VALUES ('20', '华岳移民', 'bjhuayue888 ', '7', 'https://mp.weixin.qq.com/s?timestamp=1514256786&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMXxo-kw*6qWhYRAkjfnZE890EGgW2SAFO-q35EbYuN*seckFAwssB6m7JLT-VNu*9o*CytjKK2f*GyiGfl15SBpuARXebI-D0ZMvI9ZG4sbOLbA9dVh4VhW1X4fG70FLeQzLaICN**OFJThKFPOHRz9A=', '1');
INSERT INTO `dede_quanquan` VALUES ('21', '美国研究生留学', 'meiguoduyan', '149', 'https://mp.weixin.qq.com/s?timestamp=1514256961&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX*E3ZZ--bTWNtDECRajVn2QFYb*z8iL9q7XMbPuNWaDrNylYrpDXuATW2mumckqn7sB1GXG9KW7p4QN4Q-hOEiPFlA2xNuhtdQg9uVyyQvryzWt7TngOzjsfa-sBI1j-Rt23yRK2ymCXJ7L11VNFraQ=', '1');
INSERT INTO `dede_quanquan` VALUES ('22', '领英留学', 'gh_dba3771bf84e ', '21', 'https://mp.weixin.qq.com/profile?src=3&timestamp=1514256912&ver=1&signature=a*zs3jyvF8-ng1HSh11-ELdudnjIxnxiJO6KemlPUl16LB6CkhMcJiFHQ9AyAcxoCLXakq-MOpYTx3knuzOe7w==', '1');
INSERT INTO `dede_quanquan` VALUES ('23', '山东留学帮', 'sd_liuxue', '', 'https://mp.weixin.qq.com/s?timestamp=1514257541&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMXz9t1i*gnPU7hyRr*bOlt83W8s0NwX0sxBmKA3peBJd-8F-Mybnc*eXT3z70JwBLz3KuPyvgOmuE5BTlTXV-97ASzOzLbqDPEf-Y73IRKUjq8svOt8n*aeMvHD1zKBm6QZ3OIk9SoAf1V6WkFI7QAsk=', '1');
INSERT INTO `dede_quanquan` VALUES ('24', '海外留学政策', 'fgzhwlx ', '56', 'https://mp.weixin.qq.com/s?timestamp=1514257763&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMXxrvYR3MSw4zs4zwaWcHCVK7PXalao74sQ6emyKYn3QnCpTT7JT1C-5tkTdAkXOSgcbHwb1Wy4IX5J2tqZ5Xu*ZDqfySiAAE7tKUKrhCY1lD5mb1myMC5fUIWfETj7jbpu5RB5GUk*jJhMUEoaNTtmA=', '1');
INSERT INTO `dede_quanquan` VALUES ('25', '东力移民留学', 'dongli-group ', '32', 'https://mp.weixin.qq.com/s?timestamp=1514257886&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX4APcyOyhWLXHLvLXW*seWwEZNCbM1-m4v3klHmq7doSvUfQSAvvpsbMSD9kQOh1d2B3ssuqfwV81K8NEVslNclI4fzXGQVPuJ0rAnVBArJW5jCF834LAvmJIZWTtnvihu0cMAtL6XRRjL1*ixpkWQc=', '1');
INSERT INTO `dede_quanquan` VALUES ('26', '美国留学中心', 'USAgogogo', '111', 'https://mp.weixin.qq.com/s?timestamp=1514258488&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMXy0qIGVxc*MzjvA6O5Oq5wVI5FwGgyeR3anI73yDJSXyrH0G65luXXjR5-RQshDtcsFwq0mZsHoRkl*e9u8V3VFmbk9IsApj2LF6je4wIBIZkyyWABLwXBnqVYBnHkX8Tk1J4p8CK*U4iTx8ZuYdS08=', '1');
INSERT INTO `dede_quanquan` VALUES ('27', '英国留学中心', 'liuxueyingguo ', '79', 'https://mp.weixin.qq.com/s?timestamp=1514258559&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX-Cui8xlhl4f3iMxqC55KJ84JnnCUeh0uP9Y1VV58715OUt2gifOCvoFNUeE0Ck1G1seF5yOyJJTf84cqq73RPf1mgLDaACehQbc24CH8hHE4r5kdJv0QeFYkfs4-XeHLOXmTFnRABpV0FjiNHSfnH4=', '1');
INSERT INTO `dede_quanquan` VALUES ('28', '百利天下留学', 'bltxjy ', '105', 'https://mp.weixin.qq.com/s?timestamp=1514258970&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX0mgyAl4V2C6Q*QxJ08DSOB4wwKfenhCt6NzNtayhOFbJp*MYcQbrzphC4UJ75jlfK1-YSUQWz0LKoMULhiHqdSCkmy2keECkbst9LuuVKyjykrluESIMjvMaYtYWuBEcgdpEgZteZvFlB16lbTpTI8=', '1');
INSERT INTO `dede_quanquan` VALUES ('29', '英国留学', 'UKliuxue ', '81', 'https://mp.weixin.qq.com/s?timestamp=1514259176&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMXzZF0r2YJDfw1C6nEh9yFROUsz5NLwGIb8MoF64z5DwvGVP9fvImqolvjlcdIPq1LzD*frxKVJt2zQfXFbHTvIzGpWN2ipkXoFcdp4o9bK*G2DU*AyJj2ARg5XFibZt91ew1x5M3Lo1w8CTvaPKXxTI=', '1');
INSERT INTO `dede_quanquan` VALUES ('30', '美国留学', 'chivast-usa', '12', 'https://mp.weixin.qq.com/s?timestamp=1514259308&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX-x8kx7r4A05xjc3gnbWrnQsZfWnLChRMo5y2Dgt1bUqf6lV8SmIUVJfMLzszGEsWBjpDwiwHV7wA7K1R-byAHO4m5N2Yk1KOYVz-mhRQ2zaVmYLOeOz52jnVH1jjFacTP3zZfecVfuhor8y7Q3ZGDM=', '1');
INSERT INTO `dede_quanquan` VALUES ('31', '上外留学', 'swliuxue ', '55', 'https://mp.weixin.qq.com/s?timestamp=1514259592&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX7nl0jtdZMsnkOb5g*LlUu1Nt0WSxgGhReFmarvIbCv0JmdebYm6cDUK4jNZooFFnQxTpaJaMpxTwZdnX*fnft4YKQsQqN-r8Yretjz8oTV39kYinx7kzftC1oTYhHjqKcTKpilJ*XLID1jtSpe8*0k=', '1');
INSERT INTO `dede_quanquan` VALUES ('32', '美国高中留学申请', 'Nacel_China ', '13', 'https://mp.weixin.qq.com/profile?src=3&timestamp=1514259502&ver=1&signature=UqIWDLlMYHqtSjZlSZeYN22tHlnsbpGxEaKed-pJKg9BSvcoYjK9*oH-R3p5km0Gm8PTSdO0srCMrLWdF6A8JA==', '1');
INSERT INTO `dede_quanquan` VALUES ('33', '澳洲留学么', 'gh_2d06d3d53c19 ', '29', 'https://mp.weixin.qq.com/s?timestamp=1514259793&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX5siDwQ6XxgPBnah*kubruFWeRqvT-9SyGKBF35FeuLrnlAcZkKZgpAb5NI0XYG4lszOaaYrh3*fBznH68Q5pnECi06fFWH1kzqztpF4tCLmoDwrQRQxULStNTGP02UfBKElbqdZueNNL2tSaTJnA48=', '1');
INSERT INTO `dede_quanquan` VALUES ('34', '荣耀移民留学', 'glorygroup ', '42', 'https://mp.weixin.qq.com/s?timestamp=1514259899&src=3&ver=1&signature=FfXR2-8lg8yx0vXHlibMX*AoKdUevrNxMUOQf9gSZzpzTCATge2AVT85s2wN*kScoWF3QKHkgxPyneAZrzg0sWFj*YoXDXT6wu5VjlYheZhcdUjihgXmntWflM33a-Wbme6eWK4Bwcm65SRL3S313*084RWk2jHECC2rTzapO5M=', '1');
INSERT INTO `dede_quanquan` VALUES ('35', '新东方美国本科留学', 'meibenliuxue ', '58', 'https://mp.weixin.qq.com/s?timestamp=1514260046&src=3&ver=1&signature=1AmSeWWO7*A4fGPuEIkzXNDlMAkxcpvq7A53Q6Fr5j7DhQs9rsp7cZrnmfSBNqJYZSK2FzsRoH007*kwc99tXn7wdAZfUqz4K2Q8qN6WgBJpRo*TFClqmvuSwx*4E1sQWQ3v6N59F8rubEjQPxBPUIaEeqklL8Yr7RfM3ZAh-xY=', '1');
INSERT INTO `dede_quanquan` VALUES ('36', '大华留学', 'dahuajiaoyu ', '42', 'https://mp.weixin.qq.com/s?timestamp=1514260404&src=3&ver=1&signature=1AmSeWWO7*A4fGPuEIkzXCJ*Oaj9eQpNrGkNsAadEJdPKDSERbqReLTHx1CWCCDVN7xSDpapMWE0SihbKEi8J*odzlF0U0W0XXeJSTPPerM-G8PqpHcsUnKwF2zn9tNufzT*mRCp41j8RA*6DlCxC5tdTyzPZf9E7FAwn2*lZfY=', '1');
INSERT INTO `dede_quanquan` VALUES ('37', 'WE留学', 'bjstmj ', '29', 'https://mp.weixin.qq.com/s?timestamp=1514260568&src=3&ver=1&signature=1AmSeWWO7*A4fGPuEIkzXFWJxhPfzXc2uJTvkPJ6LuHt75H9bPL26wGav*N3Mzrlvj9Zpr4XVKoUImZvcvgXqmyHGUIl-*58kNHdJeC*yKpDhtGi55DdKaubnnGc6P4RVPZcWNMdkKuKNjqFSIrMOcGNc4HlrF8onsYHttATiPw=', '1');
INSERT INTO `dede_quanquan` VALUES ('38', '留学全世界', 'zhongyuliuxue ', '35', 'https://mp.weixin.qq.com/s?timestamp=1514260685&src=3&ver=1&signature=1AmSeWWO7*A4fGPuEIkzXDMAodlz2K*MqNEe0cPjwiWkNSmWFU6r-sAuq854lJ9JnDNAoZDqo8wMdS8fubHtv-OGQ-5PCCKSy*VJZ7*N6zN4TlO1L8syJnVWmVwmWU*TmFUuf30lAps0*P*wUM4WOj8onfetHk3gHG6wnGoYUQU=', '1');
INSERT INTO `dede_quanquan` VALUES ('39', '铭洋留学', 'mingyangliuxue ', '51', 'https://mp.weixin.qq.com/s?timestamp=1514260850&src=3&ver=1&signature=1AmSeWWO7*A4fGPuEIkzXNQohb2Q9SbkLMb7evnUCkwz9Oob2AZwhbowJ-uV0EsgQ6el6Z1oTyQpr84LvfwupS1l*Ngh6V36P1BgwJgR01uZvXWdb26ZZWq2*-9L7Nqja28rgWoqXl200iMcrdNqlDAC2Ft5tm8Znd7nsgTvbFs=', '1');
