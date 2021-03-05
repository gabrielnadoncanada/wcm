
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
    },
    updateEntity: function(params, element, event)
    {
        event.preventDefault();
        $("#submit").click();
    }


});


