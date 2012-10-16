/* Default class modification */
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline"
} );

/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings ) {
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
}

/* Bootstrap style pagination control */
$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {
		"fnInit": function( oSettings, nPaging, fnDraw ) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function ( e ) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};

			$(nPaging).addClass('pagination').append(
				'<ul>'+
					'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
					'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
				'</ul>'
			);
			var els = $('a', nPaging);
			$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
		},

		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

			if ( oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			}
			else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}

			for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
				// Remove the middle elements
				$('li:gt(0)', an[i]).filter(':not(:last)').remove();

				// Add the new list items and their event handlers
				for ( j=iStart ; j<=iEnd ; j++ ) {
					sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
					$('<li '+sClass+'><a href="#">'+j+'</a></li>')
						.insertBefore( $('li:last', an[i])[0] )
						.bind('click', function (e) {
							e.preventDefault();
							oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
							fnDraw( oSettings );
						} );
				}

				// Add / remove disabled classes from the static elements
				if ( oPaging.iPage === 0 ) {
					$('li:first', an[i]).addClass('disabled');
				} else {
					$('li:first', an[i]).removeClass('disabled');
				}

				if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
					$('li:last', an[i]).addClass('disabled');
				} else {
					$('li:last', an[i]).removeClass('disabled');
				}
			}
		}
	}
} );

function createAlert(targetClass, title, contents) {
  targetAlert = $('<div></div>').addClass('alert').text(contents);
  if (!(typeof(targetClass) === 'undefined' || targetClass === '')) {
    targetAlert.addClass('alert-' + targetClass);
  }
  targetButton = $('<button></button>').attr('type', 'button').addClass("close").attr('data-dismiss', 'alert').text('×');
  targetTitle = $('<strong></strong>').text(title);
  targetAlert.prepend(targetTitle).prepend(targetButton);
  return targetAlert;
}

function deleteEntry(buttonElt) {
  id = $(buttonElt).attr('data-id');
	$('<div></div>').appendTo('body')
                  .html('<div><h6>Are you sure you want to delete this entry?</h6></div>')
                  .dialog({
                      modal: true, title: 'Delete Entry', zIndex: 10000, autoOpen: true,
                      width: 'auto', resizable: false,
                      buttons: {
                          Yes: function () {
                              $(buttonElt).addClass('disabled').text('Deleting...');
                              $.get('form_entry.php?action=delete&id=' + id,
                                function (data) {
                                  if (data == "1") {
                                    $(buttonElt).removeClass('btn-danger').addClass('btn-success').text('Entry successfully deleted.');
                                    var appendAlert = createAlert('success', '', 'Entry successfully deleted.');
                                  } else {
                                    $(buttonElt).removeClass('disabled').text('An error occurred deleting this entry.');
                                    var appendAlert = createAlert('error', '', 'An error occurred deleting this entry.');
                                  }
                                  $('body > .container-fluid').prepend(appendAlert);
                                });
                              $(this).dialog("close");
                          },
                          No: function () {
                              $(this).dialog("close");
                          }
                      },
                      close: function (event, ui) {
                          $(this).remove();
                      }
                  });
    }

$(document).ready(function () {
  $('.dropdown-toggle').dropdown();
  /* Table initialisation */
  var defaultSortColumn = 0;
  var defaultSortOrder = "asc";
  var tableNode = false;
  $('.dataTable').each(function() {
  	// see if there's a default-sort column. if not, default to the first column.
  	defaultSortColumn = $(this).find('thead > tr > th.dataTable-default-sort').index('.dataTable > thead > tr > th');
  	if (defaultSortColumn == -1) {
  		defaultSortColumn = 0;
			defaultSortOrder = "asc";
  	} else {
  		defaultSortOrder = $(this).find('thead > tr > th.dataTable-default-sort').attr("data-sort-order");
		}
    $(this).dataTable({
      "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
      "sPaginationType": "bootstrap",
      "oLanguage": {
        "sLengthMenu": "_MENU_ records per page"
      },
      "iDisplayLength": 50,
      "aaSorting": [[ defaultSortColumn, defaultSortOrder ]]
    });
		
  });
  $('.delete-button').each(function() {
    $(this).click(function (e) {
      e.preventDefault();
      deleteEntry(this);
    });
  })
  if ($('#vis').length > 0) {
    drawLargeD3Plot();
  }
});