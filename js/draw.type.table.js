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
						list: true,
						display: function (data) {
							var $img = $('<img src="'+ajax_object.img_list_types_url+'" title="'+objectL10n.column_text_img_title+'"/>');
							$img.click(function() {
								$('#TypesTableContainer').jtable('openChildTable',
							            $img.closest('tr'),
							            {
							                title: objectL10n.table_sstitle,
							                actions: {
							                    listAction: ajax_object.ajax_url.concat('?action=list_sstypes&type=' + data.record.id_type),
							                    createAction: ajax_object.ajax_url.concat('?action=create_sstypes'),
							                    updateAction: ajax_object.ajax_url.concat('?action=update_sstypes'),
							                    deleteAction: ajax_object.ajax_url.concat('?action=delete_sstypes&type=' + data.record.id_type)
							                },
							                fields: {
							                	id_type: {
							                        type: 'hidden',
							                        defaultValue: data.record.id_type
							                    },
							                    id_sstype: {
							                        key: true,
							                        create: true,
							                        edit: false,
							                        list: true
							                    },
							                    sstext: {
							                        title: objectL10n.column_sstext_title
							                    }
							                }
							            }, function (data) { //opened handler
							                data.childTable.jtable('load');
							            });
							});
							return $img;
						}
					},
					text: {
						title: objectL10n.column_text_title
					}					
				}
			});

			//Load
			$('#TypesTableContainer').jtable('load');

	})(jQuery);

