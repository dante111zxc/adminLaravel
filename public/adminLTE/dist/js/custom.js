const DATA_TABLE = {
    init: function (url, optionColumn, order) {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: optionColumn,
            order: order,
        });

    }
};
const VAR_COLOR = {
    success: 'success',
    error: 'danger',
    warning: 'warning',
};
const DATE_TIME_UI = {
    formatInDataTable: function (timeString) {
        moment.locale('vi');
        return moment(timeString).format('DD/MM/YYYY') + ' lúc ' + moment(timeString).format('h:mm a');
    }
};
const UI = {
    setSelected: function (){
        $('select').on('change', function (e) {
            e.preventDefault();
            let allOption = $(this).find('option').removeAttr('selected');
            let option = $(this).find('option[value="'+$(this).val()+'"]');
            option.attr('selected', 'selected');
        })
    },
    checkSaleOff: function () {
        $(document).on('keyup', 'input[name="price_sale"]', function (e) {
            e.preventDefault();
            let price = $('input[name="price"]').val();
            let price_sale = $(this).val();
            if (parseInt(price_sale) < parseInt(price) == true) {
                let percent_sale = Math.round(100 - ((price_sale * 100) / price));
                $('.sale-off').text('-' + percent_sale + '%');
            } else {
                $('.sale-off').text('Giá sale phải nhỏ hơn giá gốc');
            }
        })
    },
    toSlug: function (string) {
        let slug;
        slug = string.toLowerCase();
        slug = slug.replace(/\//mig, "-");
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');

        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/“|”/gi, '');
        slug = slug.replace(/[^a-zA-Z0-9 ]/g, "");
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        slug = slug.replace(/\s/g, "-");
        slug = slug.replace(',', "");
        return slug;
    },
    toast: function (type, message, delay = 1500) {
        $('.toast').addClass('in');
        $('.toast').addClass('alert-' + VAR_COLOR[type]);
        $('.toast .message').text(message);
        setTimeout(function () {
            $('.toast').removeClass('in');
            $('.toast').removeClass('alert-' + VAR_COLOR[type]);
        }, delay);
    },
    loading: function () {
        $('form').on('submit', function () {
            $('.loading').addClass('in');
        });
    },
    delete: function () {
        $(document).on('click', '.btnDelete', function () {
            let _this = $(this);
            $('.btnConfirmDelete').attr('data-href', _this.attr('data-href'));
        });

        $(document).on('click', '.btnConfirmDelete', function () {
            let _this = $(this);
            $.ajax({
                url: _this.attr('data-href'),
                dataType: "JSON",
                method: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: _token
                },
                beforeSend: function () {

                },
                success: function (res) {
                    $('.modal').modal('hide');
                    UI.toast(res.type, res.message);
                    $('#dataTable').DataTable().ajax.reload();
                }
            })
        })
    },
    ckEditor: function (selector) {
        if (document.getElementById(selector)) {
            CKEDITOR.replace(selector, {
                height: '400px',
                toolbarGroups: [
                    {name: 'clipboard', groups: ['clipboard', 'undo']},
                    {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
                    {name: 'links'},
                    {name: 'insert'},
                    {name: 'forms'},
                    {name: 'tools'},
                    {name: 'document', groups: ['mode', 'document', 'doctools']},
                    {name: 'others'},
                    {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                    {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
                    {name: 'styles'},
                    {name: 'colors'},
                    {name: 'about'}
                ],
                colorButton_enableMore : false,
                extraPlugins: 'justify, indentblock, embedsemantic, colorbutton',
                removeButtons: 'Underline,Subscript,Superscript',
                removeDialogTabs: 'image:advanced;link:advanced',
                filebrowserImageBrowseUrl: filebrowserBrowseUrl,
            });
        }

    },
    uploadImage: function (buttonId, inputId, previewId) {
        let clearImg = $('.clear-img');
        clearImg.on('click', function (e) {
            e.preventDefault();
            let img = $(this).closest('.box-preview').find('img');
            let input = $(this).closest('.form-group').find('input[name="' + inputId + '"]');
            img.attr('src', imgDefault);
            input.val('');
            $(this).removeClass('show');
        });

        let thumbnail = document.getElementById(buttonId);
        if (thumbnail) {
            thumbnail.onclick = function (e) {
                e.preventDefault();
                UI.selectFileWithCKFinder(inputId, previewId);
            };
        }
    },
    updateSetting: function () {
        $('#form-setting').on('submit', function (e) {
            e.preventDefault();
            $('#form-setting button').prop('disable', true);
            let input = $('#form-setting').serializeArray();
            input.push({
                name : 'service',
                value: CKEDITOR.instances.service.getData(),
            });
            $.ajax({
                url: $('#form-setting').attr('action'),
                dataType: 'JSON',
                method: 'POST',
                data: input,
                beforeSend: function () {
                    $('#form-setting button').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>Loading...');
                },
                success: function (res) {
                    UI.toast(res.type, res.message);
                    setTimeout(function () {
                        window.location.reload()
                    }, '500');
                },

                error: function (request, status, error) {
                    console.log(status);
                    console.log(error);
                }
            })
        })
    },
    uploadGallery: function () {
        $(document).on('click', '.uploadGallery', function (e) {
            let $_this = $(this);
            e.preventDefault();
            CKFinder.popup({
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        let file = evt.data.files.first();
                        let imageInput = $_this.closest('.form-group').find('.input-gallery');
                        let imgPreview = $_this.closest('.form-group').find('.img-preview');
                        let imageUrl = file.getUrl();

                        imageInput.val(imageUrl.replace(appUrl.trim() + '/media/', ''));
                        imgPreview.attr('src', imageUrl);
                    });
                }
            });
        })
    },
    addGallery: function () {
        $('.addGallery').on('click', function (e) {
            e.preventDefault();
            let gallery = $('.input-gallery');
            let html = '<div class="col-12 col-md-6"> ' +
                            '<div class="form-group">' +
                                '<input type="hidden" class="form-control input-gallery" name="gallery[]">' +
                            '<div class="thumbnail">' +
                            '<a href="javascript:void(0)" class="btn btn-xs btn-danger mb-2 deleteGallery">Delete</a>'+
                                '<div class="box-preview">' +
                                    '<a href="javascript:void(0)" class="clear-img"> ' +
                                    '<i class="fa fa-close"></i></a>' +
                                    '<img class="img-preview" src="/adminLTE/dist/img/no-img.png">' +
                                '</div>\n' +
                                '<button class="btn btn-primary btn-block uploadGallery">Upload Gallery</button>' +
                            '</div>' +
                            '</div>' +
                        '</div>';
            $(this).closest('.form-row').append(html);
        })
    },
    deleteGallery: function (){
        $(document).on('click', '.deleteGallery', function (e) {
            e.preventDefault();
            $(this).closest('.col-12.col-md-6').remove();
        })
    },
    selectFileWithCKFinder: function (elementId, elementIdReview) {
        CKFinder.popup({
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function (finder) {
                finder.on('files:choose', function (evt) {
                    let file = evt.data.files.first();
                    let output = document.getElementById(elementId);
                    let imgReview = document.getElementById(elementIdReview);
                    let imageUrl = file.getUrl();
                    output.value = imageUrl.replace(appUrl.trim() + '/media/', '');
                    imgReview.src = file.getUrl();
                    $('.clear-img').addClass('show');
                });

                finder.on('file:choose:resizedImage', function (evt) {
                    let output = document.getElementById(elementId);
                    output.value = evt.data.resizedUrl;
                    let imgReview = document.getElementById(elementIdReview);
                    imgReview.src = evt.data.resizedUrl;

                    $('.clear-img').addClass('show');
                });
            }
        });
    },
    activeSidebar: function () {
        let url = window.location.href;
        url = url.split('/', 5);
        url = url.join('/');
        url = url.replace('/edit', '');
        url = url.replace('/create', '');
        url = url.replace(new RegExp("\/[0-9]+", 'gm'), '');
        let el = $('.sidebar-menu').find('[href="' + url + '"]');
        let parent = el.parent('li').addClass('active');
        parent.parents('li').addClass('active');
    },
    init: function () {
        UI.setSelected();
        UI.checkSaleOff();
        UI.delete();
        UI.ckEditor('content');
        UI.ckEditor('desc');
        UI.ckEditor('service');
        UI.ckEditor('email_content');
        UI.uploadImage('uploadThumbnail', 'thumbnail', 'thumbnailPreview');
        UI.uploadImage('uploadLogo', 'logo', 'logoPreview');
        UI.uploadImage('uploadFavicon', 'favicon', 'faviconPreview');
        UI.uploadGallery();
        UI.addGallery();
        UI.deleteGallery();
        UI.activeSidebar();
        UI.updateSetting();
        UI.loading();
    }
}

UI.init();

