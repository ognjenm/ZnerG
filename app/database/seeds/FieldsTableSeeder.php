<?php

class FieldsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('metaDatas')->truncate();

		// $data = array(
		// 	array('id' => 1, 'id_metaData' => 22, 'name' => 'id', 'description' => null, 'isLinked' => 'No', 'id_dataType' => 1, 'length' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
		// 	array('id' => 19, 'id_metaData' => 22, 'name' => 'Quill', 'description' => 'Office Supplies database', 'status' => 'Updated', 'created_at' => new DateTime, 'updated_at' => new DateTime
		// ));

		// // Uncomment the below to run the seeder
		// DB::table('fields')->insert($data);
	}
/*
INSERT INTO `fields` (`id`, `id_metaData`, `name`, `description`, `isLinked`, `id_dataType`, `length`, `precision`, `scale`, `values`, `default`, `isNullable`, `id_structure`, `isFullSearch`, `isActive`, `isSystem`, `isPk`, `isReference`, `positionReference`, `positionUI`, `created_at`, `updated_at`, `deleted_at`) VALUES
(26, 22, 'id', NULL, 'No', 1, NULL, NULL, NULL, NULL, NULL, 'No', NULL, 'No', 'Yes', 'Yes', 'Yes', 'No', NULL, NULL, '2014-03-01 00:22:05', '2014-03-01 00:22:05', NULL),
(27, 22, 'id_instance', NULL, 'Yes', 1, NULL, NULL, NULL, NULL, NULL, 'No', 27, 'No', 'Yes', 'Yes', 'No', 'No', NULL, NULL, '2014-03-01 00:22:05', '2014-03-01 00:22:05', NULL),
(28, 22, 'id_activitiesProcess', NULL, 'Yes', 1, NULL, NULL, NULL, NULL, NULL, 'No', 6, 'No', 'Yes', 'Yes', 'No', 'No', NULL, NULL, '2014-03-01 00:22:05', '2014-03-01 00:22:05', NULL),
(29, 22, 'id_employee', NULL, 'Yes', 1, NULL, NULL, NULL, NULL, NULL, 'No', 21, 'No', 'Yes', 'Yes', 'No', 'No', NULL, NULL, '2014-03-01 00:22:05', '2014-03-01 00:22:05', NULL),
(30, 22, 'created_at', NULL, 'No', 16, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'No', NULL, 'No', 'Yes', 'Yes', 'No', 'No', NULL, NULL, '2014-03-01 00:22:05', '2014-03-01 00:22:05', NULL),
(31, 22, 'updated_at', NULL, 'No', 16, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'No', NULL, 'No', 'Yes', 'Yes', 'No', 'No', NULL, NULL, '2014-03-01 00:22:05', '2014-03-01 00:22:05', NULL),
(32, 22, 'deleted_at', NULL, 'No', 16, NULL, NULL, NULL, NULL, NULL, 'Yes', NULL, 'No', 'Yes', 'Yes', 'No', 'No', NULL, NULL, '2014-03-01 00:22:05', '2014-03-01 00:22:05', NULL),
(33, 22, 'id_address', 'Location', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 'No', 7, 'No', 'Yes', 'No', 'No', 'Yes', 2, 1, '2014-03-01 00:25:14', '2014-03-08 04:07:01', NULL),
(34, 22, 'id_contact', 'Contact', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', 13, 'No', 'Yes', 'No', 'No', 'No', 0, 3, '2014-03-01 00:26:02', '2014-03-07 17:36:14', NULL),
(35, 22, 'id_event', 'Event', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 'No', 24, 'No', 'Yes', 'No', 'No', 'Yes', NULL, 4, '2014-03-01 00:26:51', '2014-03-01 00:26:51', NULL),
(36, 22, 'id_eventNext', 'Next event', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', 24, 'No', 'Yes', 'No', 'No', 'No', NULL, 12, '2014-03-01 00:27:31', '2014-03-01 00:27:31', NULL),
(37, 22, 'DM', 'Decision Maker', 'No', 15, 0, 0, 0, 'Yes,No', 'No', 'No', NULL, 'No', 'Yes', 'No', 'No', 'No', NULL, 5, '2014-03-01 00:28:40', '2014-03-04 23:23:16', NULL),
(38, 22, 'HM', 'Home account', 'No', 15, 0, 0, 0, 'No,Quill,Staples', 'No', 'No', NULL, 'No', 'Yes', 'No', 'No', 'No', NULL, 6, '2014-03-04 23:20:52', '2014-03-04 23:20:52', NULL),
(39, 22, 'NQ', 'Non-qualified', 'No', 15, 0, 0, 0, 'Unknown,No,Yes', 'Unknown', 'No', NULL, 'No', 'Yes', 'No', 'No', 'No', NULL, 7, '2014-03-04 23:22:51', '2014-03-04 23:22:51', NULL),
(40, 22, 'id_order', 'Order information', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', 35, 'No', 'Yes', 'No', 'No', 'No', NULL, 10, '2014-03-04 23:24:38', '2014-03-04 23:26:25', NULL),
(41, 22, 'id_objection', 'Objections', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', 82, 'No', 'Yes', 'No', 'No', 'No', NULL, 8, '2014-03-04 23:43:35', '2014-03-04 23:43:35', NULL),
(42, 22, 'Sold', '', 'No', 15, 0, 0, 0, 'No,Yes', 'No', 'No', NULL, 'No', 'Yes', 'No', 'No', 'No', NULL, 9, '2014-03-05 22:15:38', '2014-03-05 22:15:38', NULL),
(43, 22, 'Amount', 'sales amount', 'No', 8, 0, 10, 2, '', '', 'Yes', NULL, 'No', 'Yes', 'No', 'No', 'No', NULL, 11, '2014-03-05 22:16:39', '2014-03-05 22:16:39', NULL),
(44, 22, 'id_business', 'Name of the Business', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', 8, 'No', 'Yes', 'No', 'No', 'No', 0, 2, '2014-03-07 17:34:59', '2014-03-07 17:35:10', NULL);
*/

}
