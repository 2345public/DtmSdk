-- use `dtm`;

DROP TABLE IF EXISTS `auths`;

CREATE TABLE `auths` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL DEFAULT '' COMMENT '域名',
  `app` varchar(255) NOT NULL DEFAULT '' COMMENT '应用名称',
  `token` varchar(255) NOT NULL DEFAULT '' COMMENT '应用token',
  `creator` varchar(255) NOT NULL DEFAULT '' COMMENT '创建人',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)，
  UNIQUE KEY `app` (`app`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='app项目授权表';


DROP TABLE IF EXISTS `barrier`;

CREATE TABLE `barrier` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `trans_type` varchar(45) DEFAULT '',
  `gid` varchar(128) DEFAULT '',
  `branch_id` varchar(128) DEFAULT '',
  `op` varchar(45) DEFAULT '',
  `barrier_id` varchar(45) DEFAULT '',
  `reason` varchar(45) DEFAULT '' COMMENT 'the branch type who insert this record',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gid` (`gid`,`branch_id`,`op`,`barrier_id`),
  KEY `create_time` (`create_time`),
  KEY `update_time` (`update_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='子事务屏障表';
