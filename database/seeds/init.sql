
--
-- 表的结构 `admin`
--

INSERT INTO `admin_menus` (`id`, `pid`, `path`, `name`, `display`, `sort`, `level`, `ico`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,0,'#','系统管理',1,2,1,'fa-globe','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(2,0,'#','用户管理',1,99,1,'fa-users','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(3,0,'logs','日志管理',1,10,1,'fa-bug','2018-10-16 09:26:10','2018-10-16 09:28:35',NULL),
	(4,0,'Base/Photos/index','图片管理',1,20,2,'fa-picture-o','2018-08-02 06:43:20','2018-10-18 05:32:35',NULL),
	(101,1,'Base/Menus/index','菜单管理',1,99,1,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(102,1,'Base/Role/index','角色管理',1,98,2,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(103,1,'Base/User/index','账号管理',1,97,2,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(104,1,'Base/Dictionary/index','数据字典',1,96,2,'','2018-10-18 07:51:05','2018-10-18 07:51:05',NULL),
	(105,1,'Base/Crud/create','Crud',1,95,2,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(501,5,'Base/Index/index','首页（必选）',0,0,2,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(502,5,'Base/Index/welcome','欢迎页',0,0,1,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(503,5,'Base/Login/logout','退出页',0,0,1,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(504,5,'Base/AttachmentInfo/upload','文件上传',0,0,2,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(519,101,'Base/Menus/create','添加菜单',0,0,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(520,101,'Base/Menus/update','修改菜单',0,0,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(521,101,'Base/Menus/destroy','删除菜单',0,0,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(522,102,'Base/Role/create','添加角色',0,0,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(523,102,'Base/Role/update','修改角色',0,0,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(524,102,'Base/Role/auth','角色授权',0,0,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(525,102,'Base/Role/destroy','删除角色',0,0,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(526,103,'Base/User/update','编辑用户',0,0,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(527,103,'Base/User/auth','为用户授权',0,1,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(528,103,'Base/User/create','添加用户',0,1,3,'','2018-10-01 00:00:00','2018-10-01 00:00:00',NULL),
	(597,2,'User/Info/index','用户列表',1,1,1,'','2018-04-05 06:39:13','2018-04-05 06:39:13',NULL),
	(598,597,'User/Info/create','添加',0,1,1,'','2018-04-05 06:39:13','2018-04-05 06:39:13',NULL),
	(599,597,'User/Info/update','修改',0,1,1,'','2018-04-05 06:39:13','2018-04-05 06:39:13',NULL),
	(600,597,'User/Info/destroy','删除',0,1,1,'','2018-04-05 06:39:13','2018-04-05 06:39:13',NULL),
	(601,597,'User/Info/view','查看',0,1,1,'','2018-04-05 06:39:13','2018-04-05 06:39:13',NULL),
	(615,4,'Base/Photos/delete','删除图片',0,98,2,'','2018-10-24 01:38:38','2018-10-24 01:38:38',NULL),
	(616,4,'Base/AttachmentInfo/upload','上传图片',0,99,2,'','2018-10-24 01:39:08','2018-10-24 01:39:08',NULL),
	(617,4,'Base/Photos/move','移动图片',0,97,2,'','2018-10-24 01:40:07','2018-10-24 01:40:07',NULL),
	(618,4,'Base/AttachmentClass/add','添加分类',0,96,2,'','2018-10-24 01:40:53','2018-10-24 01:40:53',NULL),
	(619,4,'Base/AttachmentClass/delete','删除分类',0,95,2,'','2018-10-24 01:41:54','2018-10-24 01:41:54',NULL);


INSERT INTO `base_dictionary` (`id`, `dictionary_table_code`, `dictionary_code`, `key`, `value`, `name`, `sort`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1, 'global', 'sex', 'male', '1', '男', '',  '2018-10-01 00:00:00', '2018-10-01 00:00:00', NULL),
	(2, 'global', 'sex', 'female', '0', '女', '',  '2018-10-01 00:00:00', '2018-10-01 00:00:00', NULL),
	(15, 'global', 'bool', '', '0', '否', '', '2018-10-01 00:00:00', '2018-10-01 00:00:00', NULL),
	(16, 'global', 'bool', '', '1', '是', '', '2018-10-01 00:00:00', '2018-10-01 00:00:00', NULL);


