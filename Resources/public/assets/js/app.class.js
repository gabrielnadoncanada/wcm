//Initialize for backend cms

$.Class({
    namespace: 'app',

    initFileWidgetFix: function () {

        $(document).ready(function (e) {
            $('a.remove-img').each(function () {
                $(this).on('click', function () {
                    if ($(this).siblings('span.btn').children('input:file').siblings('input:hidden.toDelete'))
                    {
                        $(this).siblings('span.btn').children('input:file').siblings('input:hidden.toDelete').val(1);
                        $(this).siblings('span.btn').children('input:file').value = null;
                        $(this).parent().parent().find('img').attr('src', '/bundles/bcicms/assets/img/image_placeholder.jpg');
                    }
                    else {
                        $(this).siblings('span.btn').children('input:file').value = null;
                        $(this).parent().parent().find('img').attr('src', '/bundles/bcicms/assets/img/image_placeholder.jpg');
                    }
                });
            });

            $('input:file.fileInputFix').each(function () {
                if ($(this)[0].files.length === 0 && $(this).attr('filepath') !== "") {
                    $(this).parent('span.btn').siblings('a.remove-img').css('display', 'block');
                    $(this).siblings('input:hidden.toDelete').val(0);
                } else if ($(this)[0].files.length === 0) {
                    $(this).parent('span.btn').siblings('a.remove-img').css('display', 'none');
                    $(this).siblings('input:hidden.toDelete').val(1);
                } else {
                    $(this).parent('span.btn').siblings('a.remove-img').css('display', 'block');
                    $(this).siblings('input:hidden.toDelete').val(0);
                }


                $(this).on('change', function () {
                    if ($(this)[0].files.length === 0)
                    {
                        $(this).parent('span.btn').siblings('a.remove-img').css('display', 'none');
                        $(this).siblings('input:hidden.toDelete').val(1);
                    }
                    else
                    {
                        $(this).parent('span.btn').siblings('a.remove-img').css('display', 'block');
                        $(this).siblings('input:hidden.toDelete').val(0);
                    }
                });
            })

        });
    },
    setUpMetaSelect:function(element) {
        //Hiding all fields
        $(element).parents('div.metaPrototype').find('div.trmetaname').hide();
        $(element).parents('div.metaPrototype').find('div.trmetaproperty').hide();
        $(element).parents('div.metaPrototype').find('div.trmetacontent').hide();
        $(element).parents('div.metaPrototype').find('div.trmetaimagefile').hide();
        $(element).parents('div.metaPrototype').find('input:text').val('');
        $(element).parents('div.metaPrototype').find('textarea').val('');

        let elementSelected = $(element).children().children("option:selected");
        //Show all fields
        if ($(elementSelected).data('display-name') === 'CUSTOM' )
        {
            $(element).parents('div.metaPrototype').find('div.trmetaname').show();
            $(element).parents('div.metaPrototype').find('div.trmetaproperty').show();
            $(element).parents('div.metaPrototype').find('div.trmetacontent').show();
        }
        //IMAGES TYPE
        else if ($(elementSelected).data('display-name') === 'IMAGE' || $(elementSelected).data('display-name') === 'IMAGE_SECURE' )
        {
           if ($(elementSelected).val().includes("opengraph"))
           {
               $(element).parents('div.metaPrototype').find('div.trmetaproperty').find('input:text').val($(element).children().children("option:selected").data('property'));
               $(element).parents('div.metaPrototype').find('div.trmetaproperty').hide();
               $(element).parents('div.metaPrototype').find('div.trmetaname').hide();
               $(element).parents('div.metaPrototype').find('div.trmetacontent').hide();
               $(element).parents('div.metaPrototype').find('div.trmetaimagefile').show();
           }
           else //Twitter
           {
               $(element).parents('div.metaPrototype').find('div.trmetaname').find('input:text').val($(element).children().children("option:selected").data('name'));
               $(element).parents('div.metaPrototype').find('div.trmetaname').hide();
               $(element).parents('div.metaPrototype').find('div.trmetaproperty').hide();
               $(element).parents('div.metaPrototype').find('div.trmetacontent').hide();
               $(element).parents('div.metaPrototype').find('div.trmetaimagefile').show();
           }
        }
        //OPENGRAPH
        else if ($(elementSelected).data('type') === 'OPENGRAPH' )
        {
            $(element).parents('div.metaPrototype').find('div.trmetaproperty').find('input:text').val($(element).children().children("option:selected").data('property'));
            $(element).parents('div.metaPrototype').find('div.trmetaproperty').hide();
            $(element).parents('div.metaPrototype').find('div.trmetaname').hide();
            $(element).parents('div.metaPrototype').find('div.trmetacontent').show();

        }
        //BASIC
        else
        {
            $(element).parents('div.metaPrototype').find('div.trmetaname').find('input:text').val($(element).children().children("option:selected").data('name'));
            $(element).parents('div.metaPrototype').find('div.trmetaname').hide();
            $(element).parents('div.metaPrototype').find('div.trmetaproperty').hide();
            $(element).parents('div.metaPrototype').find('div.trmetacontent').show();

        }
        let placeHolderText = '';
        let metaName = $(element).children().children("option:selected").data('name');
        let metaProperty = $(element).children().children("option:selected").data('property');

        if (metaName === 'keyword')
        {
            placeHolderText = 'Ex: apples, bananas, peaches ..';
        }
        else if (metaProperty === 'og:image' || metaProperty === 'og:url')
        {
            placeHolderText = 'Ex: http://example.com/ogp.jpg';
        }
        else if (metaProperty === 'og:image:secure_url' || metaProperty === 'og:url')
        {
            placeHolderText = 'Ex: https://example.com/ogp.jpg';
        }
        $("label[for='" + $(element).attr('id') + "']").html('Méta de type: '+$(element).children().children("option:selected").data('type'));
        $(element).parents('div.metaPrototype').find('input:text').attr('placeholder', placeHolderText);
        $(element).parents('div.metaPrototype').find('textarea').attr('placeholder', placeHolderText);
    },
    initDisplayMetaTypeInLabel: function (params, element, event) {
        $(document).ready(function (e) {
            if ($('.metaSelect').length > 0) {
                $('.metaSelect').each(function () {
                    $("label[for='" + $(this).attr('id') + "']").html('Méta de type: ' + $(this).children().children("option:selected").data('type'));
                });
            }
        });
    },
    addFromPrototypeMeta: function(params, element, event) {
        var ctn   = $($(element).data('container')),
            ctr   = (ctn.data('widget-counter') | ctn.children().length) + 1,
            proto = $(ctn.data('prototype').replace(/__name__/g, ctr));

        //Disable options that already apper in other selectpicker.
        var protoSelect = proto.find('select');

        $(protoSelect).on('change', function ()
        {
            app.setUpMetaSelect(this);
        });

        //Enable selectpicker plugin on protoype.
        // proto.find(".selectpicker").selectpicker();
        // proto.find("select").selectpicker();

        $(proto).find('div.trmetaname').hide();
        $(proto).find('div.trmetaproperty').hide();
        $(proto).find('div.trmetacontent').hide();
        $(proto).find('.selectpicker').selectpicker();
        ctn.data('widget-counter', ctr);
        ctn.find('.empty').hide();
        ctn.prepend(proto);
    },

    delete_submit: function (params, element, event) {
        event.preventDefault();
        $(params).submit();
    },

    deleteSection: function (a, b, c) {
        var selectedEffect = 'blind',
            options = {};

        // some effects have required parameters
        if (selectedEffect === "scale") {
            options = {percent: 50};
        } else if (selectedEffect === "size") {
            options = {to: {width: 200, height: 60}};
        }

        if($(b).closest('#bodySortable').length > 0) {
            // Run the effect
            $(b).closest(".section, .block").hide(selectedEffect, options, 300);
        }
    },

    addFromPrototype: function(params, element, event) {
        var ctn   = $($(element).data('container')),
            ctr   = (ctn.data('widget-counter') | ctn.children().length) + 1,
            proto = $(ctn.data('prototype').replace(/__name__/g, ctr));

        ctn.data('widget-counter', ctr);
        ctn.find('.empty').hide();
        ctn.append(proto);
    },

    removePrototype: function(params, element, event) {
        $(element).closest(params.ctn||'.card').remove();
    },

    removeMeta: function(params, element, event) {
        $(element).closest('div.card').remove();
    },

    updateRequired: function(params, element, event) {
        console.log('test');
    },
    initDateTimePicker: function() {
        if ($('.datetimepicker').length > 0) {
            $('.datetimepicker').datetimepicker({
                format: 'Y/MM/DD H:mm:ss',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove'
                }
            });
        }
    },
    initSelectPicker: function() {
        $(document).ready(function () {
            $('.selectpicker').each(function () {
                $(this).selectpicker();
            });
        });
    },
    initTinymce: function() {
        if ($('.tinymce_flag').length > 0) {
            $('.tinymce_flag').each(function () {
                // $(this).hide();
                tinymce.init({
                    mobile: {
                        theme: 'silver'
                    },
                    selector: '#' + $(this).attr('id'),
                    images_upload_url: '/cms/upload/image',
                    image_caption: true,
                    // datablock: $(this).data('block'),
                    automatic_uploads: false,
                    plugins: "advlist autolink link lists image media filemanager code responsivefilemanager template",
                    toolbar: 'undo redo | styleselect | bold | alignleft alignright aligncenter alignjustify | floatleft floatright | bullist numlist | link unlink image responsivefilemanager | media | code | template | span | removeformat',
                    menubar: false,
                    media_live_embeds: true,
                    valid_children: window.custom_tiny_config.valid_children || "+a[div|h1|h2|h3|h4|h5|h6|p|#text|span],+ul[div|h1|h2|h3|h4|h5|h6|p|#text|li],+div[li],+body[style]",
                    extended_valid_elements: "i",
                    content_css: '/build/app.css',
                    height: $(this).data('height') != undefined ? $(this).data('height') : '250px',
                    external_filemanager_path: "/bundles/bcicms/assets/js/filemanager/",
                    filemanager_title: "Gestionnaire de fichiers",
                    external_plugins: {
                        "responsivefilemanager": "plugins/responsivefilemanager/plugin.min.js",
                        "filemanager": "/bundles/bcicms/assets/js/filemanager/plugin.min.js"
                    },
                    templates: window.custom_tiny_config.templates,
                    style_formats: window.custom_tiny_config.style_formats,
                    formats: window.custom_tiny_config.formats,
                    content_style: window.custom_tiny_config.content_style,
                    style_formats_merge: true,
                    style_formats_autohide: true,
                    relative_urls: false,
                    setup: function (editor) {
                        editor.ui.registry.addButton('span', {
                            text: 'Span',
                            onAction: function (_) {
                                editor.insertContent('&nbsp;<span class="span">'+ editor.selection.getContent({format: 'text'})+' </span>&nbsp;');
                            }
                        });
                        // function getHistory(){
                        //     $.ajax({
                        //         type: "GET",
                        //         url: "/cms/page/" + $('body').data('locale') + "/" + $('body').data('page') + "/" + editor.settings.datablock,
                        //     }).done(function (data) {
                        //         function createHistory(date, content) {
                        //             return {
                        //                 type: 'menuitem',
                        //                 text: date,
                        //                 onAction: function () {
                        //                     editor.setContent(content);
                        //                 }
                        //             };
                        //         }
                        //
                        //         var objects = [];
                        //         for (let item of data.content) {
                        //             objects.push(createHistory(item.date, item.body));
                        //         }
                        //         editor.ui.registry.addMenuButton('history', {
                        //             text: 'History',
                        //             fetch: function (callback) {
                        //                 var items = objects;
                        //                 callback(items);
                        //             }
                        //         });
                        //         editor.bodyElement.setAttribute('style', '');
                        //     });
                        // }
                        editor.on('init', function(event) {
                            $(editor.getBody().parentNode).bind('dragover dragenter dragend drag drop', function(e) {
                                e.stopPropagation();
                                e.preventDefault();
                            });
                            $(editor.getDoc()).bind('draggesture', function(e) {
                                e.stopPropagation();
                                e.preventDefault();
                            });
                            // getHistory();
                        });
                        editor.ui.registry.addButton('floatleft', {
                            text: 'Image gauche',
                            onAction: function (_) {
                                let node = tinymce.activeEditor.selection.getNode();
                                node.setAttribute('style', "");
                                node.setAttribute('data-mce-style', "");
                                if ($(node).hasClass("right")) {
                                    $(node).removeClass("right");
                                }
                                if ($(node).hasClass("left")) {
                                    $(node).removeClass("left");
                                    return
                                }
                                $(node).addClass("left");
                            }
                        });
                        editor.ui.registry.addButton('floatright', {
                            text: 'Image droite',
                            onAction: function (_) {
                                let node = tinymce.activeEditor.selection.getNode();
                                node.setAttribute('style', "");
                                node.setAttribute('data-mce-style', "");
                                if ($(node).hasClass("left")) {
                                    $(node).removeClass("left");
                                }
                                if ($(node).hasClass("right")) {
                                    $(node).removeClass("right");
                                    return
                                }
                                $(node).addClass("right");
                            }
                        });
                    },

                    images_upload_handler: function (blobInfo, success, failure) {
                        var xhr, formData;
                        xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', '/cms/upload/image');

                        xhr.onload = function() {
                            var json;

                            if (xhr.status != 200) {
                                failure('HTTP Error: ' + xhr.status);
                                return;
                            }

                            json = JSON.parse(xhr.responseText);

                            if (!json || typeof json.location != 'string') {
                                failure('Invalid JSON: ' + xhr.responseText);
                                return;
                            }

                            success(json.location);
                        };
                        formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());

                        xhr.send(formData);
                    }
                });
            });
        }
    },
    draftMode: function(params, element, event) {
        if ($(element).is(':checked')) {
            $('.publishedAt input').attr("disabled", true);
        } else {
            $('.publishedAt input').attr("disabled", false);
        }
    },

    setPrincipal:function(params, element, event) {

        $.ajax({
            method: "post",
            url: params,
            dataType: "json",
            data: {
                'nada':"NADA"
            },
        }).done( function(response)
        {
           location.reload();
        }).fail(function(jxh,textmsg,errorThrown)
        {

            console.log(textmsg);
            console.log(errorThrown);
        });
    },
     modalEditImage: function(params, element, event)
    {
        if ($('#modalEditImage').length > 0)
        {
            $('#newImageTitle').val(params[0]);
            $('#newImageAlt').val(params[1]);
            //For saveEditFunction
            window.temp = params[2];
            $('#modalEditImage').modal("show").on('hide', function ()
            {
                $('#newImageTitle').val('');
                $('#newImageAlt').val('');
                $('#imageID').val('');
                $('#modalEditImage').modal('hide')
            });
        }
    },
    saveEditImage: function (params, element, event)
    {
        $('#modalEditImage').modal('hide');
        var newImgTitle = $("#newImageTitle").val();
        var newImgAlt = $("#newImageAlt").val();
        $("#newImageTitle").val('');
        $("#newImageAlt").val('');
        var url = params.replace("*", window.temp);
        $.ajax({
            method: "post",
            url: url,
            dataType: "json",
            data: {
                'newTitle': newImgTitle,
                'newAlt': newImgAlt
            },
        }).done( function(response)
        {
            location.reload();
        }).fail(function(jxh,textmsg,errorThrown)
        {
            console.log(textmsg);
            console.log(errorThrown);
        });
    },
    buildNotification: function (type, message, posY, posX) {
        $.notify({
            icon: "add_alert",
            message: message,
        }, {
            type: type,
            delay: 0,
            allow_dismiss: true,
            placement: {
                from: posY,
                align: posX
            },
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            }
        })
    },
    initDataTableStyle: function () {
        $(document).ready(function (e) {
            if ($(".material-datatables").length > 0)
            {
                //Top plugins
                $(".dt-buttons").css("float","left");
                $(".dt-buttons").css("margin","25px");

                $(".dataTables_filter").css("float","right");
                $(".dataTables_filter").css("margin","25px");
                //Bottom plugins
                $(".dataTables_length").css("width","400px");
                $(".dataTables_length").css("float","left");
                $(".dataTables_length").css("margin","25px");

                $(".dataTables_paginate").css("width","400px");
                $(".dataTables_paginate").css("float","right");
                $(".dataTables_paginate").css("margin","25px");

                $(".dt-button").each(function (e)
                {
                    $(this).removeClass("dt-button");
                    $(this).addClass("btn");
                    $(this).addClass("btn-rose");
                });

                $(".dataTables_length select").selectpicker({
                    'width':'100px'
                });
                // Alling selectpicker elements with text Ex: Afficher [SELECTPICKER] enregistrements
                $("div.btn-group.bootstrap-select.form-control.form-control-sm").css("margin","0");
                $("div.btn-group.bootstrap-select.form-control.form-control-sm").css("width","122px");
            }
        });
    },
    initFileInputDelete: function (params, element, event) {
        $(document).ready(function (e) {
            $('input:file.deletable').each(function (element) {
                var inputFile = $(this);
                $(this).parents('span').siblings('a.deletable').on("click", function()
                {

                    $(this).siblings('span').children('input:file').replaceWith( $(this).siblings('span').children('input:file').val('').clone( true ) );

                });
                $(this).on({
                    change: function(){ console.log( "Changed" ) },
                    focus: function(){ console.log(  "Focus"  ) }
                });
            });
        });
    }
});
