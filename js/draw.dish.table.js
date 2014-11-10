/**
 * Draw the table of dishes
 */

(function($) {

		    //Prepare jTable
			$('#DishesTableContainer').jtable({
				title: objectL10n.table_title,
				pageSize: 20,
				paging: true,
				sorting: true,
				multiSorting: true,
				actions: {
					listAction: ajax_object.ajax_url.concat('?action=list_dishes'),
					createAction: ajax_object.ajax_url.concat('?action=create_dish'),
					updateAction: ajax_object.ajax_url.concat('?action=update_dish'),
					deleteAction: ajax_object.ajax_url.concat('?action=delete_dish')
				},
				fields: {
					id_dish: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					name: {
						title: objectL10n.column_name_title,
						sorting: true
						//width: '40%'
						//type: 'date',
					},
					composition: {
						title: objectL10n.column_composition_title,
						sorting: false
						//width: '40%'
						//type: 'date',
					},
					type: {
						title: objectL10n.column_type_title,
						options: ajax_object.ajax_url.concat('?action=list_types')
						//width: '40%'
						//type: 'date',
					},
					sstype: {
						title: objectL10n.column_sstype_title,
						dependsOn: 'type',
						options: function (data) {
	                        return ajax_object.ajax_url.concat('?action=list_sstypes&type=' + data.dependedValues.type);
	                    }
						//width: '40%'
						//type: 'date',
					},
					picture: {
						title: objectL10n.column_picture_title,
						sorting: false,
						//width: '40%'
						//type: 'date',
						create: false,
						edit: false,
						list: false						
					}
				}
			});

			//Load person list from server
			$('#DishesTableContainer').jtable('load');

	})(jQuery);