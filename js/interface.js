function initWidgetConsole() {
	$( "#bookConsole>div>div" ).draggable({ 
		connectToSortable: "#widgetAreaBook",
		helper: "clone",
		revert: 'invalid',
		cursor: 'pointer',
		zIndex: 10000,
		appendTo: ".book",
		start: function(e, ui) {
			$(ui.helper).addClass("ui-draggable-helper-content");
			$(ui.helper).find( "span:last" ).remove();
		}
	})
	$('#bookUser>div').hover(
		function() {
			$( this ).append('<span style="position: absolute; top: 0; right: 0;"><i class="fa fa-times fa-border fa-fw deleteBookUser"></i></span>');
		}, function() {
			$( this ).find( "span:last" ).remove();
		}
	);
	$('#bookBin>div').hover(
		function() {
			$( this ).append('<span style="position: absolute; top: 0; right: 0;"><i class="fa fa-times fa-border fa-fw deleteWidget"></i></span>');
		}, function() {
			$( this ).find( "span:last" ).remove();
		}
	);
	
	$( "#structureConsole>div>div" ).draggable({ 
		connectToSortable: "#widgetAreaStructure",
		helper: "clone",
		revert: 'invalid',
		cursor: 'pointer',
		zIndex: 10000,
		appendTo: ".book",
		start: function(e, ui) {
			$(ui.helper).addClass("ui-draggable-helper-content");
			$(ui.helper).find( "span:last" ).remove();
		}
	})
	$('#structureUser>div').hover(
		function() {
			$( this ).append('<span style="position: absolute; top: 0; right: 0;"><i class="fa fa-times fa-border fa-fw deleteStructureUser"></i></span>');
		}, function() {
			$( this ).find( "span:last" ).remove();
		}
	);
	$('#structureBin>div').hover(
		function() {
			$( this ).append('<span style="position: absolute; top: 0; right: 0;"><i class="fa fa-times fa-border fa-fw deleteWidget"></i></span>');
		}, function() {
			$( this ).find( "span:last" ).remove();
		}
	);
	
	$( "#contentConsole>div>div" ).draggable({ 
		connectToSortable: "#widgetArea",
		helper: "clone",
		revert: 'invalid',
		cursor: 'pointer',
		zIndex: 10000,
		appendTo: ".book",
		start: function(e, ui) {
			$(ui.helper).addClass("ui-draggable-helper-content");
			$(ui.helper).find( "span:last" ).remove();
		}
	})
	$('#widgetBin>div').hover(
		function() {
			$( this ).append('<span style="position: absolute; top: 0; right: 0;"><i class="fa fa-times fa-border fa-fw deleteWidget"></i></span>');
		}, function() {
			$( this ).find( "span:last" ).remove();
		}
	);
	$('#widgetUser>div').hover(
		function() {
			$( this ).append('<span style="position: absolute; top: 0; right: 0;"><i class="fa fa-times fa-border fa-fw deleteWidgetUser"></i></span>');
		}, function() {
			$( this ).find( "span:last" ).remove();
		}
	);
}

function loadBookTemplates() {
	if($('#bookTemplates').length > 0) {
		$.ajax({ type: "GET", url: "/ajax/book_templates_list.php", success: function(html){
			$('#bookTemplates').html(html);
			initWidgetConsole()
			}
		});
	}	
}
function loadBookBin() {
	if($('#bookBin').length > 0) {
		$.ajax({ type: "GET", url: "/ajax/book_bin_list.php", success: function(html){
			$('#bookBin').html(html);
			initWidgetConsole()
			}
		});
	}	
}
function loadBookUser() {
	if($('#bookUser').length > 0) {
		$.ajax({ type: "GET", url: "/ajax/book_user_list.php", success: function(html){
			$('#bookUser').html(html);
			initWidgetConsole()
			}
		});
	}	
}

function loadStructureBin() {
	if($('#structureBin').length > 0) {
		var book_id = $('#book_id').val();
		$.ajax({ type: "GET", url: "/ajax/structure_bin_list.php", data: 'book_id='+book_id, success: function(html){
			$('#structureBin').html(html);
			initWidgetConsole()
			}
		});
	}	
}

function loadStructureUser() {
	if($('#structureUser').length > 0) {
		$.ajax({ type: "GET", url: "/ajax/structure_user_list.php", success: function(html){
			$('#structureUser').html(html);
			initWidgetConsole()
			}
		});
	}	
}

function loadWidgetBin() {
	if($('#widgetBin').length > 0) {
		var chapter_id = $('#chapter_id').val();
		$.ajax({ type: "GET", url: "/ajax/widget_bin_list.php", data: 'chapter_id='+chapter_id, success: function(html){
			$('#widgetBin').html(html);
			initWidgetConsole()
			}
		});
	}	
}

function loadWidgetUser() {
	if($('#widgetUser').length > 0) {
		$.ajax({ type: "GET", url: "/ajax/widget_user_list.php", success: function(html){
			$('#widgetUser').html(html);
			initWidgetConsole()
			}
		});
	}	
}

function createUploader(ele) {
		var actionurl = '/ajax/file_uploader.php';
		var uploadtype;
		if(ele.hasClass('cover')) {
			uploadtype = 'cover';
			actionurl = '/ajax/uploader_cover.php';
		}
		if(ele.hasClass('catalog_cover')) {
			uploadtype = 'catalog_cover';
			actionurl = '/ajax/uploader_catalog_cover.php';
		}
		var widget_id = ele.attr('id').replace(/image_/, "");
		//var widget = $('#image_'+widget_id);
		var num = 0;
		var numdocs = 0;
		var uploader = new qq.FileUploader({
			element: ele[0],
			multiple: false,
			allowedExtensions: ['jpg', 'jpeg', 'png'],
			classes: {
            // used to get elements from templates
            button: 'ui-upload-button',
            drop: 'ui-upload-drop-area',
            dropActive: 'ui-upload-drop-area-active',
            list: 'ui-upload-list',
                        
            file: 'ui-upload-file',
            spinner: 'ui-upload-spinner',
            size: 'ui-upload-size',
            cancel: 'ui-upload-cancel',

            // added to list item when upload completes
            // used in css to hide progress spinner
            success: 'ui-upload-success',
            fail: 'ui-upload-fail',
        },
			template: '<div class="ui-upload-button"></div>' +
					'<div class="ui-upload-drop-area"><span>Bild hier hereinziehen</span></div>' +
					'<div class="ui-upload-list"></div></div>',
			fileTemplate: '<span id="avatar" style="width: 74px;">' +
					'<span class="ui-upload-file docitem"></span><br />' +
					'<span class="ui-upload-spinner"></span><br />' +
					'<span class="ui-upload-size"></span><br /><br />' +
					'<a class="ui-upload-cancel" href="#">Abbrechen</a><br />' +
					//'<span class="ui-upload-failed-text">Failed</span>' +
				'</span>',
			action: actionurl,
			sizeLimit: 2*1024*1024, // max size
			params: {
				//path: 'classes/user_image',
				//request: 'createNew',
				widget_id: widget_id
				//module: this.name
			},
			onSubmit: function(id, fileName){ 
				$('.ui-upload-list').show();
				/*if(uploadtype == 'cover' || uploadtype == 'catalog_cover') {
					$('#book_image').find('span.widgetSaving').addClass('active');
				} else {
					$('#widget_'+widget_id).find('span.widgetSaving').addClass('active');
				}*/
			},
			onProgress: function(id, fileName, loaded, total){},
			onComplete: function(id, fileName, data){
				$('.ui-upload-list').hide();
				$('.ui-upload-drop-area').hide();
				var timestamp = new Date().getTime();
				if(uploadtype == 'cover') {
					//var src = '/books/'+data.uid+'/'+data.book_id+'/Resources/Templates/ebook/cover.jpg';
					var src = '/books/'+data.uid+'/uploads/'+data.image+'?'+timestamp;
					$('#book_image .image_display img').attr('src',src);
				    //$('#book_image').find('span.widgetSaving').removeClass('active');
				} else if(uploadtype == 'catalog_cover') {
					var src = '/books/'+data.uid+'/uploads/cover_'+data.book_id+'.jpg?'+timestamp;
					$('#book_image .image_display img').attr('src',src);
				    //$('#book_image').find('span.widgetSaving').removeClass('active');
				} else {
					var src = '/books/'+data.uid+'/uploads/'+data.image+'?'+timestamp;
					$('#widget_'+data.id+' .image_display img').attr('src',src);
					//$('#widget_'+widget_id).find('span.widgetSaving').removeClass('active');
				}
			},
			onCancel: function(id, fileName){
				$('.ui-upload-list').hide();
				//$('#avatarBinItem').show();
				},
				// messages                
        messages: {
            typeError: 'Folgenden Bildformate werden unterstützt: jpg, png',
            sizeError: 'Die maximal erlaubte Dateigröße beträgt 2 MB.',
            minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
            emptyError: "{file} is empty, please select files again without it.",
            onLeave: "Bitte warten Sie bis der Upload beendet ist."            
        },
        showMessage: function(message){
            $.prompt(message);
        }       ,
			debug: true
		});
		
		/*var name = $('#avatarImage').css('background-image');
		var patt=/\"|\'|\)/g;
		var img = name.split('/').pop().replace(patt,'');
		if(img == "avatar.jpg") {
			$('#avatarBinItem').hide();
		}*/
	}

/*$(window).scroll(function() {
    // change class of header to a background
	// slide scroll down button
	if ($(window).scrollTop() > 230) {
        $("#contentConsole").stop().animate({
                marginTop: $(window).scrollTop()
            });
    } else {
         $("#contentConsole").stop().animate({
                marginTop: 230
            });
    }
});*/


function widgetAreaHeight() {
		$("#widgetArea").height('auto');
		$("#widgetArea").height($("#widgetArea").height());
	}

$(window).load(function() {
 $("#widgetArea").height($("#widgetArea").height());
});


// JavaScript Document
$(document).ready(function() {
	
	var $sidebar = '';
	var $toptabs = $("#tabs ul");
	if($("#structureConsole").length > 0) { $sidebar = $("#structureConsole"); }
	if($("#contentConsole").length > 0) { $sidebar = $("#contentConsole"); }
	
	if($sidebar != '') {
	var $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 32;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
			$toptabs.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
			$toptabs.stop().animate({
				marginTop: 0
            });
        }
    });
	}
	
	
	
	
	//initWidgetConsole()
	//loadBookTemplates()
	loadBookUser()
	loadBookBin()
	loadStructureUser()
	loadStructureBin()
	loadWidgetUser()
	loadWidgetBin()
	
	/*if($('#widgetBin').length > 0) {
		$.ajax({ type: "GET", url: "/ajax/widget_bin_list.php", success: function(html){
			$('#widgetBin').html(html);
			initWidgetConsole()
			}
		});
	}*/
	
	if($(".user-image-uploader").length > 0) {
		$(".user-image-uploader").each(function() {
		createUploader($(this));
		});
	}
	
	
	$(document).on('click', '#newBook',function(e) {
		e.preventDefault();
		$.ajax({ type: "POST", url: "/ajax/book_new.php", success: function(html){
				//$('#widgetAreaBook').prepend('<a href="ebook_edit.php?id='+id+'">Neues Buch</a>');
				$('#widgetAreaBook').prepend(html);
			}
		});
	});
	
	$(document).on('click', '#generateEbook',function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		$('#editions>div').hide();
		$('#editions>span').show();
		$('#removeEbooks').hide();
		$.ajax({ type: "POST", url: "/ajax/ebook_generate_all.php", data: "id="+id, success: function(data){
				if(data) {
					$('#editions>div').show();
					$('#editions>span').hide();
					$('#removeEbooks').show();
				}
			}
		});
	});
	$(document).on('click', '#removeEbooks',function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		$('#editions>div').hide();
		$('#editions>span').show();
		$('#removeEbooks').hide();
		$.ajax({ type: "POST", url: "/ajax/ebook_remove_all.php", data: "id="+id, success: function(data){
				if(data) {
					//$('#editions>div').hide();
					$('#editions>span').hide();
				}
			}
		});
	});
	$(document).on('click', '#publishEbook',function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		$.ajax({ type: "POST", url: "/ajax/ebook_generate_all.php", data: "id="+id+"&publish=1", success: function(data){
				if(data) {
					$('#publishEbook,#depublishEbook').toggle();
				}
			}
		});
	});
	$(document).on('click', '#depublishEbook',function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		$.ajax({ type: "POST", url: "/ajax/ebook_generate_all.php", data: "id="+id+"&publish=0", success: function(data){
				if(data) {
					$('#publishEbook,#depublishEbook').toggle();
				}
			}
		});
	});
	
	
	/**
/* Global Console Toggle
**/
	
	$('div.widgetsConsole').on('click', 'h3.toggle',function(e) {
		e.preventDefault();
		$(this).toggleClass('closed');
		$(this).find('i').toggleClass('fa-rotate-90');
		$(this).next().slideToggle('fast');
		
	});
	

/**
/* Books Edit
**/
	
	$( "#widgetAreaBook" ).droppable({
				accept: '#structureConsole div',
				drop : function(ev, ui) {
				}
			})
			 .sortable({
						containment: "#widgetAreaBook",
						items: "> div",
						axis: "y",
						handle: '.handle',
						stop: function(event, ui) {
							if (ui.item.hasClass("template")) {
								var book_id = ui.item.attr('rel');
								$.ajax({ type: "GET", url: "/ajax/book_add_from_template.php", data: "book_id="+book_id, success: function(html){
										ui.item.replaceWith(html);
									}
								});
							}
							if (ui.item.hasClass("userwidget")) {
								var book_id = ui.item.attr('rel');
								$.ajax({ type: "GET", url: "/ajax/book_add_from_user.php", data: "book_id="+book_id, success: function(html){
										ui.item.replaceWith(html);
									}
								});
							}
							if (ui.item.hasClass("bin")) {
								var book_id = ui.item.attr('rel');
								$.ajax({ type: "GET", url: "/ajax/book_add_from_bin.php", data: "book_id="+book_id, success: function(html){
										ui.item.replaceWith(html);
										loadBookBin()
									}
								});
							}
						}
			})
			 /*.bind('sortupdate', function(event, ui) {
				var order = $( "#widgetAreaBook" ).sortable("serialize");
				$.ajax({ type: "GET", url: "/ajax/book_sort.php", data: order, cache: false, success: function(data){
					}
				});
	})*/
	/*$('#widgetAreaBook').on('click', '.toggleWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$(this).find('i').toggleClass('fa-angle-double-up').toggleClass('fa-angle-double-down');
		$('#'+id).find('>div:eq(1)').slideToggle();
	});*/
	
	$('#widgetAreaBook').on('click', '.shareWidgetRemove',function(e) {
		e.preventDefault();
		var book_id = $(this).attr('rel');
		var share_id = $(this).attr('href');
		$.prompt('Möchten Sie die Mitarbeit an diesem Ebook beenden?', {
				title: "Teilen beenden",
				buttons: { "Ja": true, "Nein": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "POST", url: "/ajax/book_share_remove.php", data: 'share_id='+share_id, cache: false, success: function(data){
							$('#book_'+book_id).slideUp(function() { $(this).remove() });
							}
						});
						
					}	
				}
		});
	});
	
	
	$('#widgetAreaBook').on('click', '.shareWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		var sharedwith = '';
		$.ajax({ type: "GET", url: "/ajax/book_shared_users.php", data: 'id='+id, cache: false, success: function(html){
			$('.shareDetails').html(html);
			}
		});

		var state1 = 	'<div class="sharePopup"><p><label style="width:90px">E-mail Adresse</label> ' +
						'<input type="text" name="email" id="email" /></p>' +
						'<p><label style="width:90px">Nachricht</label> ' +
						'<textarea name="message" id="message"></textarea></p>' +
						'<p><a href="'+id+'" class="sendInvitation">Einladung abschicken</a><hr /></div>' +
						'<div class="shareDetails"></div>';
		$.prompt(
				 /*html, {
				title: "Dieses Ebook mit anderen Benutzern teilen",
				buttons: { "Schließen": false }*/
			{
				state0: {
					html: state1,
					title: "Dieses E-Book mit anderen Benutzern teilen",
					buttons: { "Schließen": false }
			},
				state1: {
					title: 'Teilen löschen',
					html:'<div class="shareDetailsDelete"></div>',
					buttons: { Nein: false, Ja: true },
					submit:function(e,v,m,f){ 
						if(v) {
							var share_id = $('#removeShareUser').attr('rel');
							//$.prompt.goToState('state0')
							$.ajax({ type: "POST", url: "/ajax/book_share_remove.php", data: 'share_id='+share_id, cache: false, success: function(data){
																																				   
								$.ajax({ type: "GET", url: "/ajax/book_shared_users.php", data: 'id='+id, cache: false, success: function(html){
									$('.shareDetails').html(html);
									$.prompt.goToState('state0');
									}
								});
								}
							});
						} else {
							$.prompt.goToState('state0');
						}
						e.preventDefault();
					}
				}
		});
	});
	
	function validateEmail(email) { 
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
   		 return re.test(email);
	}
	
	function checkifexists(email) {
		var links = -1;
		var re = new RegExp(email, 'ig');
		$('.shareDetails span').each(function (index) {
			$(this).css('background','none');
			if ($(this).text().match(re)) {
				links = index;
			}
		});
		return links;
	}
	
	$('body').on('click', '.sendInvitation',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		var email = $('#email').val();
		if(!validateEmail(email)) {
			$('#email').css('background','red');
			return false;
		}
		var message = $('#message').val();
		var index = checkifexists(email);
		if(index > -1) {
			$('.shareDetails span:eq('+index+')').css('background','green');
			return false;
		}
		$.ajax({ type: "POST", url: "/ajax/book_share.php", data: 'id='+id+'&email='+email+'&message='+message, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/ajax/book_shared_users.php", data: 'id='+id, cache: false, success: function(html){
				$('.shareDetails').html(html);
				}
			});
			}
		});
	});
	
	$('body').on('click', '.removeShare',function(e) {
		e.preventDefault();
		$.prompt.goToState('state1');
		var id = $(this).attr('rel');
		var shareid = '<p id="removeShareUser" rel="' + id + '">' + $(this).parent().find('span').html() + '</p>';
		$('.shareDetailsDelete').html(shareid);
	});
	
	$('#widgetAreaBook').on('click', '.binWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$.prompt('Möchten Sie diese Vorlage in den Papierkorb verschieben?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/book_bin.php", data: 'id='+id, cache: false, success: function(data){
							$('#book_'+id).slideUp(function() { $(this).remove() });
							loadBookBin()
							}
						});
					}	
				}
		});
	});
	$('#widgetAreaBook').on('click', '.saveWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$.prompt('<label>Titel <input type="text" name="fname" value=""></label>',{
				title: "Vorlage speichern",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						var title = f.fname;
						if(title != '') {
							$.ajax({ type: "GET", url: "/ajax/book_user_save.php", data: 'id='+id+'&title='+title, cache: false, success: function(data){
							loadBookUser()
							}
						});
						}
					}	
				}
		});
	});
	$('#bookConsole').on('click', '.deleteWidget',function(e) {
		e.preventDefault();
		e.stopPropagation();
		var id = $(this).parent().parent().attr('rel');
		$.prompt('Möchten Sie diese Vorlage unwiderruflich löschen?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/book_delete.php", data: 'id='+id, cache: false, success: function(data){
							loadBookBin()
							}
						});
					}	
				}
		});
	});
	$('#bookConsole').on('click', '.deleteBookUser',function(e) {
		e.preventDefault();
		e.stopPropagation();
		var id = $(this).parent().parent().attr('rel');
		$.prompt('Möchten Sie diese Vorlage unwiderruflich löschen?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/book_user_delete.php", data: 'id='+id, cache: false, success: function(data){
							loadBookUser()
							}
						});
					}	
				}
		});
	});
	// click on content console items
	$('#bookConsole').on('click', '>div>div',function(e) {
		e.preventDefault();
		if ($(this).hasClass("userwidget")) {
			var book_id = $(this).attr('rel');
			$.ajax({ type: "GET", url: "/ajax/book_add_from_user.php", data: "book_id="+book_id, success: function(html){
					$('#widgetAreaBook').prepend(html);
				}
			});
		}
		if ($(this).hasClass("bin")) {
			var book_id = $(this).attr('rel');
			$.ajax({ type: "GET", url: "/ajax/book_add_from_bin.php", data: "book_id="+book_id, success: function(html){
					$('#widgetAreaBook').append(html);
					loadBookBin()
				}
			});
		}
	});
	
	
	/* county check box */
	$('#country').change(function() {
		var id = $('#book_id').val();
		var country_id = $(this).val();
		$.ajax({ type: "POST", url: "/ajax/settings_edit.php", data: "id="+id+"&field=country&value="+country_id, success: function(data){
				if(data) {
					
				}
			}
		});
	}); 
	
	/* Target Groups Checkboxes */
	$('#book_targetgroups').on('click', '.fa',function(e) {
		e.preventDefault();
		var checked = $(this);
		var target_id = checked.attr('rel');
		checked.toggleClass('fa-square-o').toggleClass('fa-check-square-o');
		var status = 0;
		if(checked.hasClass('fa-square-o')) {
			status = 0;
		} else {
			status = 1;
		}
		var book_id = $('#book_id').val();
		$.ajax({ type: "POST", url: "/ajax/ebook_target.php", data: "book_id="+book_id+"&target_id="+target_id+"&status="+status, success: function(data){
				if(data) {
					
				}
			}
		});
	});
	
	/* Categories Checkboxes */
	$('#book_categories').on('click', '.fa',function(e) {
		e.preventDefault();
		var checked = $(this);
		var cat_id = checked.attr('rel');
		checked.toggleClass('fa-square-o').toggleClass('fa-check-square-o');
		var status = 0;
		if(checked.hasClass('fa-square-o')) {
			status = 0;
		} else {
			status = 1;
		}
		var book_id = $('#book_id').val();
		$.ajax({ type: "POST", url: "/ajax/ebook_category.php", data: "book_id="+book_id+"&cat_id="+cat_id+"&status="+status, success: function(data){
				if(data) {
					
				}
			}
		});
	});

	/* License Radio Buttons */
	$('#book_license').on('click', '.fa-circle-thin',function(e) {
		e.preventDefault();
		var selected = $(this);
		var license = selected.attr('rel');
		var text = '';
		switch(license) {
			case '0':
				text = 'auf nicht im Katalog setzen?';
			break;
			case '1':
				text = 'unter CC by SA veröffentlichen?';
			break;
			case '2':
				text = 'unter CC 0 veröffentlichen?';
			break;
		}

		$.prompt(text, {
				title: "Veröffentlichung",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						var id = $('#book_id').val();
						$('#book_license').find('.fa-circle').toggleClass('fa-circle').toggleClass('fa-circle-thin');
						selected.toggleClass('fa-circle').toggleClass('fa-circle-thin');
						$.ajax({ type: "POST", url: "/ajax/ebook_generate_all.php", data: "id="+id+"&publish="+license, success: function(data){
								if(data) {
									
								}
							}
						});
					}	
				}
		});
		
	});

/**
/* Book Structure edit
**/

	/*var editFormBookoptions = { 
    success:    function() { 
        //alert('Thanks for your comment!'); 
		} 
	}; 
     $('#editFormBook').ajaxForm(editFormBookoptions);*/
	 
	 /*var editFormBookStructureoptions = { 
		beforeSubmit: formStructureProcess,
		success:    function() { 
			//alert('Thanks for your comment!'); 
		} 
	}; */
     //$('#editFormBookStructure').ajaxForm(editFormBookStructureoptions);
	
	/*function formStructureProcess(formData, form, poformOptions) {
		//var content = $('#widget_id div').html();
		var id; var content;
		$('#widgetAreaBook .editBox').each(function() {
			id = $(this).attr('id').replace(/widget_/, "");
			if($(this).find('.chapter').length > 0) {
			content = $(this).find('h3.mce-content-body').html();
			formData[formData.length] = { "name": "content["+id+"]", "value": content };
			}
		})
		
	}*/

	/*$( "#bookConsole>div" ).draggable({ 
			connectToSortable: "#widgetAreaBook",
			helper: "clone",
			revert: 'invalid',
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-content");
			}
	});*/
	
	
/**
/* Book Structure edit
**/
	$( "#widgetAreaStructure" ).droppable({
				accept: '#structureConsole div',
				drop : function(ev, ui) {
				}
			})
			 .sortable({
						containment: "#widgetAreaStructure",
						items: "> div",
						axis: "y",
						handle: '.handle',
						start: function(event, ui) {
							ui.placeholder.height(ui.item.height()+6);
						},
						stop: function(event, ui) {
							if (ui.item.hasClass("chapter")) {
								var book_id = $('#book_id').val();
								var type = 'chapter';
								$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetAreaStructure" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("introduction")) {
								var book_id = $('#book_id').val();
								var type = 'introduction';
								$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetAreaStructure" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("toc")) {
								var book_id = $('#book_id').val();
								var type = 'toc';
								$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetAreaStructure" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("cover")) {
								var book_id = $('#book_id').val();
								var type = 'cover';
								$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										var order = $( "#widgetAreaStructure" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("lof")) {
								var book_id = $('#book_id').val();
								var type = 'lof';
								$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetAreaStructure" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("license")) {
								var book_id = $('#book_id').val();
								var type = 'license';
								$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetAreaStructure" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("userwidget")) {
								var book_id = $('#book_id').val();
								var widget_id = ui.item.attr('rel');
								$.ajax({ type: "GET", url: "/ajax/structure_add_from_user.php", dataType:  'json', data: "book_id="+book_id+"&widget_id="+widget_id, success: function(data){
										ui.item.replaceWith(data.html);
										if(data.type != 'cover') { $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
										var order = $( "#widgetAreaStructure" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("bin")) {
								var book_id = $('#book_id').val();
								var widget_id = ui.item.attr('rel');
								$.ajax({ type: "GET", url: "/ajax/structure_add_from_bin.php", dataType:  'json', data: "book_id="+book_id+"&widget_id="+widget_id, success: function(data){
										ui.item.replaceWith(data.html);
										loadStructureBin()
										if(data.type != 'cover') { $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
										var order = $( "#widgetAreaStructure" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
						}
			}).bind('sortupdate', function(event, ui) {
				var order = $( "#widgetAreaStructure" ).sortable("serialize");
				$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
					}
				});
	})
	/*$('#widgetAreaStructure').on('click', '.toggleWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$(this).find('i').toggleClass('fa-angle-double-up').toggleClass('fa-angle-double-down');
		$('#'+id).find('>div:eq(1)').slideToggle();
	});*/
	$('#widgetAreaStructure').on('click', '.binWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$.prompt('Möchten Sie diese Vorlage in den Papierkorb verschieben?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/structure_bin.php", data: 'id='+id, cache: false, success: function(data){
							$('#widget_'+id).slideUp(function() { $(this).remove() });
							loadStructureBin()
							}
						});
						
					}	
				}
		});
	});
	$('#widgetAreaStructure').on('click', '.saveWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$.prompt('<label>Titel <input type="text" name="fname" value=""></label>',{
				title: "Vorlage speichern",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						var title = f.fname;
						if(title != '') {
							$.ajax({ type: "GET", url: "/ajax/structure_user_save.php", data: 'id='+id+'&title='+title, cache: false, success: function(data){
							loadStructureUser()
							}
						});
						}
					}	
				}
		});
	});
	$('#structureConsole').on('click', '.deleteWidget',function(e) {
		e.preventDefault();
		e.stopPropagation();
		var id = $(this).parent().parent().attr('rel');
		$.prompt('Möchten Sie diese Vorlage unwiderruflich löschen?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/structure_delete.php", data: 'id='+id, cache: false, success: function(data){
							loadStructureBin()
							}
						});
					}	
				}
		});
	});
	$('#structureConsole').on('click', '.deleteStructureUser',function(e) {
		e.preventDefault();
		e.stopPropagation();
		var id = $(this).parent().parent().attr('rel');
		$.prompt('Möchten Sie diese Vorlage unwiderruflich löschen?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/structure_user_delete.php", data: 'id='+id, cache: false, success: function(data){
							loadStructureUser()
							}
						});
					}	
				}
		});
	});
	// click on structure console items
	$('#structureConsole').on('click', '>div>div',function(e) {
		e.preventDefault();
		if ($(this).hasClass("chapter")) {
			var book_id = $('#book_id').val();
			var type = 'chapter';
			$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
					$('#widgetAreaStructure').append(data.html);
					//widgetAreaHeight()
					    $('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetAreaStructure" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("introduction")) {
			var book_id = $('#book_id').val();
			var type = 'introduction';
			$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
					$('#widgetAreaStructure').append(data.html);
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetAreaStructure" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("toc")) {
			var book_id = $('#book_id').val();
			var type = 'toc';
			$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
					$('#widgetAreaStructure').append(data.html);
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetAreaStructure" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("cover")) {
			var book_id = $('#book_id').val();
			var type = 'cover';
			$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
					$('#widgetAreaStructure').append(data.html);
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					var order = $( "#widgetAreaStructure" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("lof")) {
			var book_id = $('#book_id').val();
			var type = 'lof';
			$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
					$('#widgetAreaStructure').append(data.html);
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetAreaStructure" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("license")) {
			var book_id = $('#book_id').val();
			var type = 'license';
			$.ajax({ type: "GET", url: "/ajax/structure_add.php", dataType:  'json', data: "book_id="+book_id+"&type="+type, success: function(data){
					$('#widgetAreaStructure').append(data.html);
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetAreaStructure" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("userwidget")) {
			var book_id = $('#book_id').val();
			//var type = 'bin';
			var widget_id = $(this).attr('rel');
			$.ajax({ type: "GET", url: "/ajax/structure_add_from_user.php", dataType:  'json', data: "book_id="+book_id+"&widget_id="+widget_id, success: function(data){
					$('#widgetAreaStructure').append(data.html);
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					if(data.type != 'cover') { $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
					var order = $( "#widgetAreaStructure" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("bin")) {
			var book_id = $('#book_id').val();
			var widget_id = $(this).attr('rel');
			$.ajax({ type: "GET", url: "/ajax/structure_add_from_bin.php", dataType:  'json', data: "book_id="+book_id+"&widget_id="+widget_id, success: function(data){
					$('#widgetAreaStructure').append(data.html);
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					//widgetAreaHeight()
					loadStructureBin()
					if(data.type != 'cover') { $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
					var order = $( "#widgetAreaStructure" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/structure_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
	});

/**
/* Book Global Settings
**/
	/*var editFormBookoptions = { 
    success:    function() { 
        //alert('Thanks for your comment!'); 
		} 
	}; 
     $('#editFormBook').ajaxForm(editFormBookoptions);*/


/**
/* Book Chapter edit
**/

// edit ebook details
	/*var editFormBookContentoptions = { 
		beforeSubmit: formProcess,
		success:    function() { 
			//alert('Thanks for your comment!'); 
			$('#widgetSaving').css('background','#6C3')
		} 
	}; 
     $('#editFormBookContent').ajaxForm(editFormBookContentoptions);
	
	function formProcess(formData, form, poformOptions) {
		var title = $("#chapter_title").html();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		//var content = $('#widget_id div').html();
		$('#widgetSaving').css('background','#990000')
		var id; var content;
		$('#widgetArea .editBox').each(function() {
			//console.log($(this).attr('id'));
			id = $(this).attr('id').replace(/widget_/, "");
			if($(this).find('.textarea').length > 0) {
			content = $(this).find('div.mce-content-body').html();
			formData[formData.length] = { "name": "content["+id+"]", "value": content };
			}
		})
		
	}*/


	/*$( "#contentConsole>div>div" ).draggable({ 
			connectToSortable: "#widgetArea",
			helper: "clone",
			revert: 'invalid',
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-content");
			}
	});*/
	
	
	
	$( "#widgetArea" ).droppable({
				accept: '#contentConsole div',
				drop : function(ev, ui) {
					//$("#widgetArea").height('auto');
				}
			})
			 .sortable({
						containment: "#widgetArea",
						items: "> div",
						axis: "y",
						handle: '.handle',
						placeholder: "ui-state-highlight",
						forcePlaceholderSize: true,
						create:function(){
							//$("#widgetArea").height($("#widgetArea").height());
						},
						start: function(e, ui){
							//$("#widgetArea").height($("#widgetArea").height());
							//ui.placeholder.css('position','relative');
							ui.placeholder.height(ui.item.height()+20);
						},
						stop: function(event, ui) {
							//$("#widgetArea").height('auto');
							if (ui.item.hasClass("textarea")) {
								var chapter_id = $('#chapter_id').val();
								var type = 'textarea';
								$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										widgetAreaHeight()
										$('#widget_'+data.id+' div.textarea').tinymce(TextareaOptions);
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("image")) {
								var chapter_id = $('#chapter_id').val();
								var type = 'image';
								$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										widgetAreaHeight()
										createUploader($('#widget_'+data.id+' .user-image-uploader'));
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("video")) {
								var chapter_id = $('#chapter_id').val();
								var type = 'video';
								$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										widgetAreaHeight()
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("quiz")) {
								var chapter_id = $('#chapter_id').val();
								var type = 'quiz';
								$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										widgetAreaHeight()
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("headline1")) {
								var chapter_id = $('#chapter_id').val();
								var type = 'headline1';
								$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										widgetAreaHeight()
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							
							if (ui.item.hasClass("headline2")) {
								var chapter_id = $('#chapter_id').val();
								var type = 'headline2';
								$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										widgetAreaHeight()
										$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							
							if (ui.item.hasClass("pagebreak")) {
								var chapter_id = $('#chapter_id').val();
								var type = 'pagebreak';
								$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
										ui.item.replaceWith(data.html);
										widgetAreaHeight()
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							
							if (ui.item.hasClass("userwidget")) {
								var chapter_id = $('#chapter_id').val();
								//var type = 'bin';
								var widget_id = ui.item.attr('rel');
								$.ajax({ type: "GET", url: "/ajax/widget_add_from_user.php", dataType:  'json', data: "chapter_id="+chapter_id+"&widget_id="+widget_id, success: function(data){
										ui.item.replaceWith(data.html);
										//loadWidgetBin()
										widgetAreaHeight()
										if(data.type == 'headline1' || data.type == 'headline2') { $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
										if(data.type == 'textarea') { $('#widget_'+data.id+' div.textarea').tinymce(TextareaOptions); }
										if(data.type == 'image') { createUploader($('#widget_'+data.id+' .user-image-uploader')); $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);  }
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
							if (ui.item.hasClass("bin")) {
								var chapter_id = $('#chapter_id').val();
								//var type = 'bin';
								var widget_id = ui.item.attr('rel');
								$.ajax({ type: "GET", url: "/ajax/widget_add_from_bin.php", dataType:  'json', data: "chapter_id="+chapter_id+"&widget_id="+widget_id, success: function(data){
										ui.item.replaceWith(data.html);
										widgetAreaHeight()
										loadWidgetBin()
										if(data.type == 'headline1' || data.type == 'headline2') { $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
										if(data.type == 'textarea') { $('#widget_'+data.id+' div.textarea').tinymce(TextareaOptions); }
										if(data.type == 'image') { createUploader($('#widget_'+data.id+' .user-image-uploader')); $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
										var order = $( "#widgetArea" ).sortable("serialize");
										$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
											}
										});
									}
								});
							}
						}
			}).bind('sortupdate', function(event, ui) {
				//$("#widgetArea").height('auto');
				//$("#widgetArea").height($("#widgetArea").height());
				
				var order = $( "#widgetArea" ).sortable("serialize");
				$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
					}
				});
	})
	//$( "#widgetArea" ).css('min-height', $(this).height());
	/*$('#widgetArea').on('click', '.toggleWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$(this).find('i').toggleClass('fa-angle-double-up').toggleClass('fa-angle-double-down');
		$('#'+id).find('>div:eq(1)').slideToggle();
	});*/
	$('#widgetArea').on('click', '.binWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$.prompt('Möchten Sie diese Vorlage in den Papierkorb verschieben?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/widget_bin.php", data: 'id='+id, cache: false, success: function(data){
							$('#widget_'+id).slideUp(function() { 
								$(this).remove() 
								widgetAreaHeight()
							});
							loadWidgetBin()
							}
						});
					}	
				}
		});
	});
	$('#widgetArea').on('click', '.deleteWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$.prompt('Möchten Sie diese Vorlage unwiderruflich löschen?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/widget_delete.php", data: 'id='+id, cache: false, success: function(data){
							$('#widget_'+id).slideUp(function() { 
								$(this).remove();  
								widgetAreaHeight()
							});
							}
						});
					}	
				}
		});
	});
	$('#widgetArea').on('click', '.saveWidget',function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		$.prompt('<label>Titel <input type="text" name="fname" value=""></label>',{
				title: "Vorlage speichern",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						var title = f.fname;
						if(title != '') {
							$.ajax({ type: "GET", url: "/ajax/widget_user_save.php", data: 'id='+id+'&title='+title, cache: false, success: function(data){
							loadWidgetUser()
							}
						});
						}
					}	
				}
		});
	});
	$('#contentConsole').on('click', '.deleteWidget',function(e) {
		e.preventDefault();
		e.stopPropagation();
		var id = $(this).parent().parent().attr('rel');
		$.prompt('Möchten Sie diese Vorlage unwiderruflich löschen?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/widget_delete.php", data: 'id='+id, cache: false, success: function(data){
							loadWidgetBin()
							}
						});
					}	
				}
		});
	});
	$('#contentConsole').on('click', '.deleteWidgetUser',function(e) {
		e.preventDefault();
		e.stopPropagation();
		var id = $(this).parent().parent().attr('rel');
		$.prompt('Möchten Sie diese Vorlage unwiderruflich löschen?', {
				title: "Löschen",
				buttons: { "Ok": true, "Abbrechen": false },
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/ajax/widget_user_delete.php", data: 'id='+id, cache: false, success: function(data){
							loadWidgetUser()
							}
						});
					}	
				}
		});
	});
	// click on content console items
	$('#contentConsole').on('click', '>div>div',function(e) {
		e.preventDefault();
		if ($(this).hasClass("textarea")) {
			var chapter_id = $('#chapter_id').val();
			var type = 'textarea';
			$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' div.textarea').tinymce(TextareaOptions);
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("image")) {
			var chapter_id = $('#chapter_id').val();
			var type = 'image';
			$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					createUploader($('#widget_'+data.id+' .user-image-uploader'));
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("video")) {
			var chapter_id = $('#chapter_id').val();
			var type = 'video';
			$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("quiz")) {
			var chapter_id = $('#chapter_id').val();
			var type = 'quiz';
			$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("headline1")) {
			var chapter_id = $('#chapter_id').val();
			var type = 'headline1';
			$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		
		if ($(this).hasClass("headline2")) {
			var chapter_id = $('#chapter_id').val();
			var type = 'headline2';
			$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					$('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		
		if ($(this).hasClass("pagebreak")) {
			var chapter_id = $('#chapter_id').val();
			var type = 'pagebreak';
			$.ajax({ type: "GET", url: "/ajax/widget_add.php", dataType:  'json', data: "chapter_id="+chapter_id+"&type="+type, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("userwidget")) {
			var chapter_id = $('#chapter_id').val();
			var widget_id = $(this).attr('rel');
			$.ajax({ type: "GET", url: "/ajax/widget_add_from_user.php", dataType:  'json', data: "chapter_id="+chapter_id+"&widget_id="+widget_id, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					if(data.type == 'headline1' || data.type == 'headline2' || data.type == 'video' || data.type == 'quiz') { $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
					if(data.type == 'textarea') { $('#widget_'+data.id+' div.textarea').tinymce(TextareaOptions); }
					if(data.type == 'image') { createUploader($('#widget_'+data.id+' .user-image-uploader')); $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions);  }
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		if ($(this).hasClass("bin")) {
			var chapter_id = $('#chapter_id').val();
			var widget_id = $(this).attr('rel');
			$.ajax({ type: "GET", url: "/ajax/widget_add_from_bin.php", dataType:  'json', data: "chapter_id="+chapter_id+"&widget_id="+widget_id, success: function(data){
					$('#widgetArea').append(data.html);
					widgetAreaHeight()
					$('html, body').animate({
							scrollTop: $('#widget_'+data.id).offset().top
						}, 1000);
					loadWidgetBin()
					if(data.type == 'headline1' || data.type == 'headline2' || data.type == 'video' || data.type == 'quiz') { $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
					if(data.type == 'textarea') { $('#widget_'+data.id+' div.textarea').tinymce(TextareaOptions); }
					if(data.type == 'image') { createUploader($('#widget_'+data.id+' .user-image-uploader')); $('#widget_'+data.id+' h3.inlineSingle').tinymce(TextOptions); }
					var order = $( "#widgetArea" ).sortable("serialize");
					$.ajax({ type: "GET", url: "/ajax/widget_sort.php", data: order, cache: false, success: function(data){
						}
					});
				}
			});
		}
		
		
		
	});
	

/**
/* Select Save
**/

$("select.saveSelect").on('change',function() {
    var field = $(this).attr('id');
	var widget = $('#book_'+field);
	var book_id = $('#book_id').val();
	var value = $(this).val();
	//widget.find('span.widgetSaving').addClass('active')
	$.post('/ajax/settings_edit.php', {id:book_id,field:field,value:value}, function(data){
		if(data){
			//widget.find('span.widgetSaving').removeClass('active')
		}
	});
  })


/**
/* TinyMCE
**/
	 function keyupSave(what,widget_id) {
		switch(what) {
			case 'saveSettings':
				var widget = $('#book_'+widget_id);
				//widget.find('span.widgetSaving').addClass('active')
				var tmce = widget.find('.mce-content-body');
				var content = tmce.html();
				var book_id = $('#book_id').val();
				$.post('/ajax/settings_edit.php', {id:book_id,field:widget_id,value:content}, function(data){
					if(data){
						//widget.find('span.widgetSaving').removeClass('active')
					}
				});
			break;
			case 'saveContent':
				var widget = $('#widget_'+widget_id);
				//widget.find('span.widgetSaving').addClass('active')
				var content = widget.find('.mce-content-body').html();
				$.post('/ajax/widget_edit.php', {id:widget_id,content:content}, function(data){
					if(data){
						widgetAreaHeight()
					}
				});
			break;
			case 'saveContent2':
				var widget = $('#widget_'+widget_id);
				var content = widget.find('.mce-content-body:eq(1)').html();
				$.post('/ajax/widget_edit2.php', {id:widget_id,content:content}, function(data){
					if(data){
						widgetAreaHeight()
					}
				});
			break;
			case 'saveStructure':
				var widget = $('#widget_'+widget_id);
				//widget.find('span.widgetSaving').addClass('active')
				var content = widget.find('h3.mce-content-body').html();
				$.post('/ajax/structure_edit.php', {id:widget_id,content:content}, function(data){
					if(data){
						//widget.find('span.widgetSaving').removeClass('active')
					}
				});
			break;
		}
		//if($('#editFormBookContent').length > 0) { $('#editFormBookContent').submit() }
		//if($('#editFormBookStructure').length > 0) { $('#editFormBookStructure').submit() }
		//console.log(what+id)
		
		/*var id; var content;
		$('#widgetArea .editBox').each(function() {
			//console.log($(this).attr('id'));
			id = $(this).attr('id').replace(/widget_/, "");
			if($(this).find('.textarea').length > 0) {
			content = $(this).find('div.mce-content-body').html();
			formData[formData.length] = { "name": "content["+id+"]", "value": content };
			}
		})*/
	}
	 
	 function tinymceSetup(ed) {
		var timer;
		var d = 700;
		
		ed.on('init', function() {
            var attr = $('#'+ed.id).attr('placeholder');
			if (typeof attr !== typeof undefined && attr !== false) {
				if(ed.getContent() == '') {
					$('#'+ed.id).addClass('placeholder');
					ed.setContent(attr)
				}
			}
        });
		

		if($('#'+ed.id).hasClass('settings')) {
			var what = 'saveSettings';
			if($('#'+ed.id).hasClass('inlineSingle')) {
				var widget = $('#'+ed.id).parent().parent();
			} else {
				var widget = $('#'+ed.id).parent();
			}
			var id = widget.attr('id').replace(/book_/, "");
		}
		if($('#'+ed.id).hasClass('structure')) {
			var what = 'saveStructure';
			if($('#'+ed.id).hasClass('inlineSingle')) {
				var widget = $('#'+ed.id).parent().parent();
			} else {
				var widget = $('#'+ed.id).parent();
			}
			var id = widget.attr('id').replace(/widget_/, "");
		}
		if($('#'+ed.id).hasClass('content')) {
			var what = 'saveContent';
			if($('#'+ed.id).hasClass('inlineSingle')) {
				var widget = $('#'+ed.id).parent().parent();
			} else {
				var widget = $('#'+ed.id).parent();
			}
			var id = widget.attr('id').replace(/widget_/, "");
		}
		if($('#'+ed.id).hasClass('content2')) {
			var what = 'saveContent2';
			if($('#'+ed.id).hasClass('inlineSingle')) {
				var widget = $('#'+ed.id).parent().parent();
			} else {
				var widget = $('#'+ed.id).parent();
			}
			var id = widget.attr('id').replace(/widget_/, "");
		}
		
		ed.on('click', function() {
			if($('#'+ed.id).hasClass('placeholder')) {
				$('#'+ed.id).removeClass('placeholder');
				ed.setContent('')
			}
		});
		ed.on('keyup', function() {
			if(!$('#'+ed.id).hasClass('placeholder')) {
				if(timer) { clearTimeout(timer); }
				timer = setTimeout(function() { keyupSave(what,id) }, d);
			}
		});
		ed.on('blur', function() {
			var attr = $('#'+ed.id).attr('placeholder');
			if (typeof attr !== typeof undefined && attr !== false) {
				if(ed.getContent() == '') {
					$('#'+ed.id).addClass('placeholder');
					ed.setContent(attr)
				}
			}
		});
		ed.on('change', function() {
			if(!$('#'+ed.id).hasClass('placeholder')) {
			if(timer) { clearTimeout(timer); }
			timer = setTimeout(function() { keyupSave(what,id) }, d);
			}
		});
		ed.on('paste', function() {
			if(!$('#'+ed.id).hasClass('placeholder')) {
			if(timer) { clearTimeout(timer); }
			timer = setTimeout(function() { keyupSave(what,id) }, d);
			}
		});
		
	}
	 
	 var TextareaOptions = {
		script_url : '/js/tinymce/tinymce.min.js',
		menubar : false,
		statusbar : false,
		resize: false,
		height : 300,
		entity_encoding: "raw",
		language : 'de_AT',
		inline: true,
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code",
			"paste"
		],
		target_list: [
			{title: 'Neues Fenster', value: '_blank'},
			{title: 'Keines', value: ''},
    	],
		style_formats: [
			{title: "Inline", items: [
				{title: "Bold", icon: "bold", format: "bold"},
				{title: "Italic", icon: "italic", format: "italic"},
				{title: "Underline", icon: "underline", format: "underline"},
				{title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
				{title: "Superscript", icon: "superscript", format: "superscript"},
				{title: "Subscript", icon: "subscript", format: "subscript"},
				{title: "Code", icon: "code", format: "code"}
			]},
			{title: "Blocks", items: [
				{title: "Paragraph", format: "p"},
				{title: "Blockquote", format: "blockquote"},
				{title: "Div", format: "div"},
				{title: "Pre", format: "pre"}
			]},
			{title: "Alignment", items: [
				{title: "Left", icon: "alignleft", format: "alignleft"},
				{title: "Center", icon: "aligncenter", format: "aligncenter"},
				{title: "Right", icon: "alignright", format: "alignright"},
				{title: "Justify", icon: "alignjustify", format: "alignjustify"}
			]}
		],
		paste_as_text: true,
		toolbar: "undo redo | styleselect | bold italic | bullist numlist | link",
		setup: tinymceSetup
	};
	 $('.editBox div.textarea').tinymce(TextareaOptions);
	 
	 var TextOptions = {
		 script_url : '/js/tinymce/tinymce.min.js',
		menubar : false,
		statusbar : false,
		resize: false,
		entity_encoding: "raw",
		language : 'de_AT',
		inline: true,
		plugins: ["paste"],
		paste_as_text: true,
		toolbar: "undo redo",
		setup: tinymceSetup
	 }
	 $('h3.inlineSingle').tinymce(TextOptions); 
	 
	$('#widgetAreaStructure').on('click', 'h3.mce-content-body',function(e) {
		e.preventDefault();
		var orig = $(this).attr('alt');
		if($(this).html() == orig) {
			$(this).val('');
		}
	});
	
	
	$('#filterCat').change(function() {
		var category = $(this).val();
		location.href = '/ebooks.php?category='+category;
	});
	$('#filterTarget').change(function() {
		var target = $(this).val();
		location.href = '/ebooks.php?target='+target;
	});
	 
});