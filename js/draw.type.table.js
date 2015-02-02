/**
 * Draw the table of dishes
 */
(function($) {

		    //Prepare jTable
			$('#TypesTableContainer').jtable({
				title: objectL10n.table_title,
				//pageSize: 20,
				//paging: true,
				//sorting: true,
				//multiSorting: true,
				actions: {
					listAction: ajax_object.ajax_url.concat('?action=list_types'),
					//createAction: ajax_object.ajax_url.concat('?action=create_types'),
					//updateAction: ajax_object.ajax_url.concat('?action=update_types'),
					//deleteAction: ajax_object.ajax_url.concat('?action=delete_types')
				},
				fields: {
					id_type: {
						key: true,
						create: false,
						edit: false,
						list: true
					},
					text: {
						title: objectL10n.column_text_title,
						//sorting: true
						//width: '40%'
						//type: 'date',
					}					
				}
			});

			//Load
			$('#TypesTableContainer').jtable('load');

	})(jQuery);


