
jQuery(document).ready(function ($) {
    var _token = $(document).find('meta[name="csrf-token"]').attr('content');
    const homeSwiper = new Swiper('.home-carousel .swiper-container', {
        lazy: true,
        pagination: {
            el: ".swiper-pagination",
            type: "progressbar",
        },

        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".home-carousel .button-next",
            prevEl: ".home-carousel .button-prev",
        },
    });
    const featureProductSwiper = new Swiper(".product-feature .swiper-container", {
        slidesPerView: 5,
        spaceBetween: 15,
        freeMode: true,
        lazy: true,
        navigation: {
            nextEl: ".product-feature .button-next",
            prevEl: ".product-feature .button-prev",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 15,
            },
            540: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 15,
            },
        },
        mousewheel: true,
        keyboard: true,
    });
    const smallProductDetailSwiper = new Swiper(".product-detail-small-swiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        lazy: true,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        navigation: {
            nextEl: ".swiper-button-next1",
            prevEl: ".swiper-button-prev1",
        },
    });
    const productDetailSwiper = new Swiper(".product-detail-swiper", {
        spaceBetween: 10,
        lazy: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        thumbs: {
            swiper: smallProductDetailSwiper,
        },
    });
    const otherProductSwiper = new Swiper(".other-product-slide", {
        slidesPerView: 5,
        lazy: true,
        spaceBetween: 30,
        navigation: {
            nextEl: ".swiper-button-next2",
            prevEl: ".swiper-button-prev2",
        },
    });
    const activeTab = function () {
        $('.list-info-link li').on('click', function (e) {
            e.preventDefault();
            $('.list-info-link li').removeClass('active');
            $(this).addClass('active');

        })
    }
    new WOW().init();

    /***rate***/
    $('#rate-star').bind('rated', function (event, value) {
        $('.vote-review').val(value);

    });


    const submitReview = function (){
        $('#submit-review').submit(function (e) {
            e.preventDefault();

            let $_this = $(this);
            $.ajax({
                url: $_this.attr('data-href'),
                dataType: "JSON",
                method: 'POST',
                data: {
                    _token: _token,
                    vote: $('.vote-review').val(),
                    type: $('.type-review').val(),
                    slug: $('.slug-review').val(),
                    user_id: $('.user-id-review').val(),
                    post_id: $('.post-id-review').val(),
                    content: $('.content-review').val(),
                },
                beforeSend: function () {
                    $('.overlay').addClass('show');
                    $('.content-review').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    $_this.find('button').prop('disable', true);
                },

                success: function (res) {
                    $_this.find('button').prop('disable', true);
                    $('.overlay').removeClass('show');
                    if (res.validatorMessage) {
                        $('.content-review').addClass('is-invalid');
                        $('<div class="invalid-feedback">'+res.validatorMessage.content[0]+'</div>').insertAfter($('.content-review'));
                    }
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: res.message,
                        type: res.type,
                        delay: 1500
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('.overlay').removeClass('show');
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: xhr.responseJSON.message,
                        type: xhr.responseJSON.type,
                        delay: 1500
                    });

                }
            })
        })
    }

    $('form').submit(function () {
        $('.overlay').addClass('show');
    });

    $('#menuMobile').hcOffcanvasNav({
        disableAt: 1140,
        customToggle: $('.toggle-menu'),
        navTitle: '',
        labelClose: 'x',
        levelTitles: false,
        levelTitleAsBack: true
    });

    /**show, hide product category feature***/
    const showHideProductCategory = function () {
        if ($('.tab-pill').length > 0) {
            $('.tab-pill').on('click', function (e) {
                e.preventDefault();
                let target = $(this).attr('data-href');

                $('.tab-pill-content').removeClass('d-flex');
                $('.tab-pill-content[data-target="'+target+'"]').addClass('d-flex');
            })
        }
    }


    /***ajax add to cart****/
    const addToCart = function () {
        if ($('.btn-buy-now').length > 0) {
            $(document).on('click', '.btn-buy-now', function (e) {
                e.preventDefault();
                let $_this = $(this);
                if ($_this.hasClass('disable')) {
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: 'Sản phẩm đã hết hàng',
                        type: 'error',
                        delay: 1500
                    });
                    return false;
                } else {

                    $.ajax({
                        url: $_this.attr('data-href'),
                        dataType: "JSON",
                        method: 'POST',
                        data: {
                            _token: _token,
                            id: $_this.attr('data-id'),
                            quantity: $('.select-quantity .quantity-input').attr('value')
                        },
                        beforeSend: function () {
                            $('.overlay').addClass('show');
                            $_this.prop('disable', true);
                        },

                        success: function (res) {
                            $_this.prop('disable', false);
                            $('.overlay').removeClass('show');
                            $('.cart-list-item').html(res.html);
                            $.toast({
                                title: 'Thông báo',
                                subtitle: 'Vừa xong',
                                content: res.message,
                                type: res.type,
                                delay: 1500
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('.overlay').removeClass('show');
                            $.toast({
                                title: 'Thông báo',
                                subtitle: 'Vừa xong',
                                content: xhr.responseJSON.message,
                                type: xhr.responseJSON.type,
                                delay: 1500
                            });

                        }
                    })
                }


            });
        }
    }

    /***ajax delete item ****/
    const deleteItemFromCart = function (element) {
        $(document).on('click', element ,function (e) {
            e.preventDefault();
            let $_this = $(this);
            $.ajax({
                url: $_this.attr('data-href'),
                dataType: "JSON",
                method: 'DELETE',
                data: {
                    _token: _token,
                    rowId: $_this.closest('.cart-item').attr('data-row-id'),
                },
                beforeSend: function () {
                    $_this.prop('disable', true);
                    $('.overlay').addClass('show');
                },
                success: function (res) {
                    $('.overlay').removeClass('show');
                    $_this.prop('disable', false);
                    if (res.code == 200) {
                        $_this.closest('.cart-item').remove();

                        if (res.data.cart_total == 0) {
                            $('.cart .cart-total').addClass('d-none');
                            $('.cart .cart-button ').addClass('d-none');
                            $('.cart-list-item').prepend('<div style="padding: 1rem; line-height: 1.5">Chưa có sản phẩm nào trong giỏ hàng</div>');
                        } else {
                            $('.cart .cart-total .total').html(res.data.cart_total);
                        }
                    }
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: res.message,
                        type: res.type,
                        delay: 1500
                    });
                    window.location.reload();
                }
            })

        });
    }

    /***ajax delete item card in checkout page***/
    const deleteItemCartInCheckOut = function () {
        $(document).on('click','.table-cart .delete', function (e) {
            e.preventDefault();
            let $_this = $(this);
            $.ajax({
                url: $_this.attr('data-href'),
                dataType: "JSON",
                method: 'DELETE',
                data: {
                    _token: _token,
                    rowId: $_this.closest('tr').attr('data-row-id'),
                },
                beforeSend: function () {
                    $_this.prop('disable', true);
                    $('.overlay.fade').addClass('show');
                },
                success: function (res) {
                    $_this.prop('disable', false);
                    if (res.code == 200) {
                        $_this.closest('tr').remove();
                    }
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: res.message,
                        type: res.type,
                        delay: 1500
                    });
                    $('.overlay.fade').removeClass('show');
                    window.location.reload();
                }
            })
        })
    }

    /***add account***/
    const addAcc = function (){
        $(document).on('click', '.addAcc',function (e) {
            e.preventDefault();
            let row = $('.acc-info .acc-info-item');
            let lastRow = row[row.length-1];
            let key = parseInt($(lastRow).attr('data-key')) + 1;
            $('.acc-info').append(addAccFormHtml(key));
        });
    }

    /***ajax update profile***/
    const updateProfile = function () {
        $('#updateProfile').on('click', function (e) {
            e.preventDefault();
            let url = $(this).closest('form').attr('action');
            let form = $(this).closest('form');
            $.ajax({
                url: url,
                dataType: "JSON",
                method: 'POST',
                data: {
                    _token: _token,
                    name: form.find('input[name="name"]').val(),
                    phone: form.find('input[name="phone"]').val(),
                    id_number: form.find('input[name="id_number"]').val(),
                    address: form.find('input[name="address"]').val(),
                    email: form.find('input[name="email"]').val(),
                    gender: form.find('select[name="gender"]').val(),
                    id: form.find('input[name="id"]').val()
                },
                beforeSend: function () {
                    $('.overlay').addClass('show');
                    form.find('.invalid-feedback').remove();
                    form.find('.form-control').removeClass('is-invalid');
                    $(this).prop('disable', true);
                },
                success: function (res) {
                    $('.overlay').removeClass('show');
                    if (res.code == 403) {
                        if (res.validatorMessage) {
                            for (const key in res.validatorMessage) {
                                form.find('[name="'+key+'"]').after('<div class="invalid-feedback">'+res.validatorMessage[key][0]+'</div>');
                                form.find('[name="'+key+'"]').addClass('is-invalid');
                            }
                        }
                    }
                    $(this).prop('disable', false);
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: res.message,
                        type: res.type,
                        delay: 2000
                    });

                }
            })
        })
    }

    /****ajax update password*****/
    const updatePassword = function () {
        $('#updatePassword').on('click', function (e) {
            e.preventDefault();
            let url = $(this).closest('form').attr('action');
            let form = $(this).closest('form');
            $.ajax({
                url: url,
                dataType: "JSON",
                method: 'POST',
                data: {
                    _token: _token,
                    id: form.find('input[name="id"]').val(),
                    password: form.find('input[name="password"]').val(),
                    new_password: form.find('input[name="new_password"]').val(),
                    confirm: form.find('input[name="confirm"]').val()
                },
                beforeSend: function () {
                    $('.overlay').addClass('show');
                    form.find('.invalid-feedback').remove();
                    form.find('.form-control').removeClass('is-invalid');
                    $(this).prop('disable', true);
                },
                success: function (res) {
                    $('.overlay').removeClass('show');
                    if (res.code == 403) {
                        if (res.validatorMessage) {
                            for (const key in res.validatorMessage) {
                                form.find('[name="'+key+'"]').after('<div class="invalid-feedback">'+res.validatorMessage[key][0]+'</div>');
                                form.find('[name="'+key+'"]').addClass('is-invalid');
                            }
                        }
                    }
                    $(this).prop('disable', false);
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: res.message,
                        type: res.type,
                        delay: 2000
                    });
                    window.location.reload();

                }
            })
        })
    }

    /***ajax pay pcoin by card phone***/
    const ajaxPayCoinByCardPhone = function () {
        $('#payCoinByCardPhone').on('click', function (e) {
            let url = $(this).attr('data-href');
            let form = $(this).closest('.modal').find('form');
            $.ajax({
                url: url,
                dataType: "JSON",
                method: 'POST',
                data: {
                    _token: _token,
                    card_type: $('select[name="card_type"]').val(),
                    card_price: $('select[name="card_price"]').val(),
                    card_serial: $('input[name="card_serial"]').val(),
                    card_code: $('input[name="card_code"]').val(),
                },
                beforeSend: function () {
                    $('.overlay').addClass('show');
                    form.find('.invalid-feedback').remove();
                    form.find('.form-control').removeClass('is-invalid');
                    $(this).prop('disable', true);
                },
                success: function (res) {
                    $('.overlay').removeClass('show');
                    if (res.code == 403) {

                        if (res.validatorMessage) {
                            for (const key in res.validatorMessage) {
                                form.find('[name="'+key+'"]').after('<div class="invalid-feedback">'+res.validatorMessage[key][0]+'</div>');
                                form.find('[name="'+key+'"]').addClass('is-invalid');
                            }
                        }
                    }
                    $(this).prop('disable', false);
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: res.message,
                        type: res.type,
                        delay: 2000
                    });

                }
            })
        });
    }
    const deleteAcc = function (){
        $(document).on('click', '.deleteAcc', function (e) {
            e.preventDefault();
            $(this).closest('.acc-info-item').remove();
        });
    }
    const addAccFormHtml = function (key){
        return ` <div class="acc-info-item" data-key="${key}">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label>Tên tài khoản</label>
                            <input type="text" name="acc_info[${key}][username]" class="form-control bg-transparent rounded-pill">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Password</label>
                            <input type="password" name="acc_info[${key}][password]" class="form-control bg-transparent rounded-pill">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label>Nền tảng</label>
                            <input type="text" name="acc_info[${key}][platform]" class="form-control bg-transparent rounded-pill" placeholder="Steam, Origin, UbiPlay...">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label>Server</label>
                            <input type="text" name="acc_info[${key}][server]" class="form-control bg-transparent rounded-pill">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label>Tên nhân vật</label>
                            <input type="text" name="acc_info[${key}][charactername]" class="form-control bg-transparent rounded-pill">
                        </div>
                     </div>
                     <div class="form-row">
                        <div class="col-12">
                        <a href="javascript:void(0)" class="btn btn-success rounded-0 deleteAcc">Xóa</a>
                        </div>
                    </div>
                </div>`;
    }
    const uploadImageBanking = function (){
        $('#uploadImageBanking').submit(function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method:"POST",
                data: new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (){
                    $('.overlay').addClass('show');
                    $(this).prop('disable', true);
                },
                success:function(res) {
                    $('.overlay').removeClass('show');
                    if (res.code == 200) {
                        $('.thumbnail-preview').html('<img class="request-img-preview" src="'+res.data+'">');
                        $('.result').html('Request ID của bạn là ' +res.transaction.request_id+ '. Vui lòng xem chi tiết tại Lịch sử giao dịch');
                    }
                    $(this).prop('disable', false);
                    $.toast({
                        title: 'Thông báo',
                        subtitle: 'Vừa xong',
                        content: res.message,
                        type: res.type,
                        delay: 2000
                    });
                }
            })
        })
        $('.custom-file-input').on('change',function(){
            let fileName = $(this)[0].files[0].name;
            $(this).next('.custom-file-label').html(fileName);
        })
    }

    const DATA_TABLE = {
        init: function (selector ,url, optionColumn, order) {
            $(selector).DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: optionColumn,
                order: order
            });
        }
    };
    const createDataTable = function (){
        let ajaxCard = $('#dataTableByCard').attr('data-href');
        let ajaxBank = $('#dataTableByBank').attr('data-href');
        let ajaxHistoryOrder = $('#dataTableHistoryOrder').attr('data-href');

        let optionColumn = [
            { data: 'id', name: 'id', class: 'text-center vertical-middle', orderable: true},
            { data: 'request_id', name: 'request_id', class: 'vertical-middle', orderable: false },
            { data: 'type', name: 'type', class: 'vertical-middle', orderable: false},
            { data: 'status', name: 'status', class: 'vertical-middle', orderable: false},
            { data: 'action', name: 'action', class: 'vertical-middle',orderable: false},
            { data: 'time', name: 'time', class: 'vertical-middle', orderable: false}
        ];
        let order = [[0, "desc"]];
        DATA_TABLE.init('#dataTableByCard',ajaxCard, optionColumn, order);
        DATA_TABLE.init('#dataTableByBank',ajaxBank, optionColumn, order);
        DATA_TABLE.init('#dataTableHistoryOrder',ajaxHistoryOrder, [
            {data :'id', name: 'id', class: 'text-center vertical-middle',  orderable: true},
            {data :'status', name: 'status', class: 'text-center vertical-middle',  orderable: true},
            {data :'action', name: 'action', class: 'text-center vertical-middle',  orderable: true},
            { data: 'time', name: 'time', class: 'vertical-middle', orderable: false}
        ], order);
    }
    const submitCheckout = function () {
        $('#btnCheckOut').on('click', function (e) {
            e.preventDefault();
            $('.overlay').addClass('show');
            $(this).prop('disable', true);
            document.getElementById('form-checkout').submit();
        })
    }
    const transactionTimeout = function () {
        let x = setInterval(function () {
            let timeOut = $('.transaction-time-out span').text();
            let distance = timeOut - 1;
            $('.transaction-time-out span').text(distance);
            if (distance == 0) {
                window.location.href = homeUrl;
                clearInterval(x);

            }
        }, 1000);
    }

    activeTab();
    submitCheckout();
    updateProfile();
    updatePassword();
    addAcc();
    deleteAcc();
    addToCart();
    deleteItemFromCart('.cart-list-item-wrapper .cart-item .delete');
    deleteItemFromCart('.widget-cart .widget-content .cart-item .delete');
    deleteItemCartInCheckOut();
    ajaxPayCoinByCardPhone();
    createDataTable();
    submitReview();
    showHideProductCategory();
    uploadImageBanking();
    transactionTimeout();
});
const selected = function (thisEl) {
    let val = $(thisEl).val();
    $(thisEl).find('option').removeAttr('selected');
    $(thisEl).find('option[value="'+val+'"]').attr('selected', 'selected');
}
const sortProduct = function (thisEl) {
    selected(thisEl);
    let form = $('#formFilter')
    form.find('input[name="sort_by"]').val($(thisEl).val());
    form.submit();
}
const checkbox = function (thisEl) {
    $(thisEl).attr("checked", true);
}
const minusQty = function (thisElement, elementParent, update){
    let minus = $(thisElement);
    if (update == true) {
        minus = $('.minus[data-id="'+$(thisElement).attr('data-id')+'"]');
    }

    let input = minus.closest($(elementParent)).find('input');
    let qty = input.val();
    let rowId = $(thisElement).closest('.cart-item').attr('data-row-id');

    if (qty == 1) {
        alert ('Số lượng nhỏ nhất là 1');
        return false;
    }

    input.val(parseInt(qty) - 1);
    input.attr('value', parseInt(qty) - 1);
    qty = input.val();
    if (update === true) {
        $.ajax({
            url: $(thisElement).attr('data-href'),
            dataType: "JSON",
            method: 'POST',
            data: {
                _token:  $(document).find('meta[name="csrf-token"]').attr('content'),
                id: $(thisElement).attr('data-id'),
                qty: qty,
                row_id: rowId
            },
            beforeSend: function () {
                $('.overlay').addClass('show');
                $(thisElement).prop('disable', true);
            },
            success: function (res) {
                if (res.code === 200) {
                    $('.cart-subtotal-text').html(res.cart_sub_total);
                    $('.cart-total-text').html(res.cart_total);
                    $('input[name="cart_total"]').val(res.cart_total.replace('.', ''));

                    /**update mini cart**/
                    $('.mini-cart-sub-total').html(res.cart_sub_total + '<sup>đ</sup>');
                    $('.mini-cart-total').html(res.cart_total + '<sup>đ</sup>');

                    $('.cart-qty').html(res.cart_count);
                }
                $.toast({
                    title: 'Thông báo',
                    subtitle: 'Vừa xong',
                    content: res.message,
                    type: res.type,
                    delay: 1500
                });
            },
            complete: function () {
                $(thisElement).prop('disable', false);
                $('.overlay').removeClass('show');
            }
        })
    }

}
const plusQty = function (thisElement, elementParent, update) {
    let plus = $(thisElement);
    if (update == true) {
        plus = $('.minus[data-id="'+$(thisElement).attr('data-id')+'"]');
    }

    let input = plus.closest($(elementParent)).find('input');
    let qty = input.val();
    let rowId = $(thisElement).closest('.cart-item').attr('data-row-id');
    input.val(parseInt(qty) + 1);
    input.attr('value', parseInt(qty) + 1);
    qty = input.val();

    if (update === true) {
        $.ajax({
            url: $(thisElement).attr('data-href'),
            dataType: "JSON",
            method: 'POST',
            data: {
                _token:  $(document).find('meta[name="csrf-token"]').attr('content'),
                id: $(thisElement).attr('data-id'),
                qty: qty,
                row_id: rowId
            },
            beforeSend: function () {
                $('.overlay').addClass('show');
                $(thisElement).prop('disable', true);
            },
            success: function (res) {
                if (res.code === 200) {
                    $('.cart-subtotal-text').html(res.cart_sub_total);
                    $('.cart-total-text').html(res.cart_total);
                    $('input[name="cart_total"]').val(res.cart_total.replace('.', ''));

                    /**update mini cart**/
                    $('.mini-cart-sub-total').html(res.cart_sub_total + '<sup>đ</sup>');
                    $('.mini-cart-total').html(res.cart_total + '<sup>đ</sup>');
                    $('.cart-qty').html(res.cart_count);
                }
                $.toast({
                    title: 'Thông báo',
                    subtitle: 'Vừa xong',
                    content: res.message,
                    type: res.type,
                    delay: 1500
                });
            },
            complete: function () {
                $(thisElement).prop('disable', false);
                $('.overlay').removeClass('show');
            }
        })
    }

}
const changeMethodPayment = function (val) {
    let form = $('#form-checkout');
    form.find('input[name="method_payment"]').val(val);
}
