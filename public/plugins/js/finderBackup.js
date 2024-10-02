(function() {
    "use strict";
    var HT = {};

    //truy cap ckfinner
    HT.ckfinner = () => {
        var uploadImages = document.querySelectorAll('.upload-image');
        uploadImages.forEach(function(uploadImage) {
            uploadImage.addEventListener('click', function() {
                var input = this;
                var type = input.getAttribute('data-type');
                HT.setupCkfinner2(input, type);
            });
        });
    };

    //hien thi ck finner
    HT.setupCkfinner2 = (object, type) => {
        if (typeof(type) === 'undefined') {
            type = 'Images';
        }

        var finder = new CKFinder(); // Đảm bảo CKFinder đã được đưa vào
        finder.resourceType = type;
        finder.selectActionFunction = function(fileUrl, data) {
            // Loại bỏ /public khỏi đường dẫn
            var cleanedUrl = fileUrl.replace('/public/', '');
            object.value = cleanedUrl; // Đặt giá trị cho input
        };
         finder.popup();
    };

    //truy cap ckedit
    HT.setupCkedit = () =>{
        if (jQuery('.ckedit')) {
            (jQuery('.ckedit')).each(function(){
                let edit = jQuery(this)
                let id = edit.attr('id')
                HT.Ckedit(id)
            })
        }
    }

    //thu vien ckedit
    HT.Ckedit = (id) =>{
        CKEDITOR.replace(id, {
        height: 250, // Chiều cao của trình soạn thảo
        removeButtons: '',
        entities: true,
        allowedContent: true,
        toolbarGroups: [
            { name: 'clipboard', groups: ['clipboard', 'undo'] },
            { name: 'editing', groups: ['find', 'selection', 'spellchecker'] },
            { name: 'links' },
            { name: 'forms' },
            { name: 'tools' },
            { name: 'insert' },
            { name: 'document', groups: ['mode', 'document', 'doctools'] },
            { name: 'colors' },
            { name: 'others' },
            '/',
            { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
            { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'] },
            { name: 'styles' },
        ]
    });
    }
//set up avt co hien anh sau khi chon test
    HT.upavt = () =>{
        jQuery('.image-target').click(function(){

            let input = jQuery(this);
            let type = 'Images';
            HT.upimgavt(input, type);
        })
    }


    //aset up avt co hien anh sau khi chon test
    HT.upimgavt = (object, type) =>{
        if (typeof(type) === 'undefined') {
            type = 'Images';
        }

        var finder = new CKFinder(); // Đảm bảo CKFinder đã được đưa vào
        finder.resourceType = type;
        finder.selectActionFunction = function(fileUrl, data) {
            // Loại bỏ /public khỏi đường dẫn
            var cleanedUrl = fileUrl.replace('/public', '');

            //object.find('img').attr('src', cleanedUrl);
            object.attr('src', cleanedUrl);
            object.siblings('input').val(cleanedUrl);
        };
         finder.popup();
    }


    //upload nhieu anh
    HT.imgs = () => {
        jQuery('.mutiimg').click(function(e){
            let object = jQuery(this);
            let target = object.attr('data-target');
            HT.upimgs(object, 'Images', target);
            e.preventDefault();
        })
    }

    //goi ham up load nhieu anh o textarea
    HT.upimgs = (object, type, target) => {
        if (typeof(type) === 'undefined') {
            type = 'Images';
        }

        var finder = new CKFinder(); // Đảm bảo CKFinder đã được đưa vào
        finder.resourceType = type;
        finder.selectActionFunction = function(fileUrl, data, allfile) {
            var html ='';
            for (let i = 0; i < allfile.length; i++) {
                var src = allfile[i].url;
                var cleanedUrl = src.replace('/public', '');
                html+= '<div><figure>'
                html+='<img src="'+cleanedUrl+'" alt="'+cleanedUrl+'" style="width:100%">'
                html+='<figcaption>Nhập mô tả hình ảnh</figcaption>'
                html+='</figure></div>'
            }

            CKEDITOR.instances[target].insertHtml(html);
        };
         finder.popup();
    }


    //di chuyen vi tri anh
    HT.changeLocationimg = () => {
        //goi ham truy cap theo # de keo tha cac phan tu
        jQuery('#sortable').sortable();
        jQuery('#sortable').disableSelection();
    }

    HT.upalbum = () => {
        jQuery('.upload-img').on('click', function(e){
            HT.uploadalbum();
            e.preventDefault();
        })
    }


    HT.uploadalbum = () => {
        var type = 'Images';


        var finder = new CKFinder(); // Đảm bảo CKFinder đã được đưa vào
        finder.resourceType = type;
        finder.selectActionFunction = function(fileUrl, data, allfile) {
            var html ='';
            for (let i = 0; i < allfile.length; i++) {
                var src = allfile[i].url;
                html +='<li class="ui-ista">'
                            html +='<div class="thum">'
                                html +='<span class="image image-scaldown">'
                                    html +='<img src="'+src+'" alt="">'
                                        html +='<input type="hidden" name="album[]" value="'+src+'">'
                                html +='</span>'
                                html +='<button class="delete-image"><i class="fa fa-trash"></i></button>'
                            html +='</div>'
                        html +='</li>'
            }

            jQuery('.click-to-upload').addClass('hidden');
            jQuery('#sortable').append(html);
            jQuery('.upload-list').removeClass('hidden');
        };
         finder.popup();
    }

    HT.deleteinAlbum = () => {
        // Xử lý sự kiện click để xóa hình ảnh
        jQuery(document).on('click', '.delete-image', function() {
            let _this = jQuery(this);
            _this.parents('.ui-ista').remove();

            // Kiểm tra lại số lượng phần tử sau khi xóa
            if (jQuery('.ui-ista').length === 0) {
                jQuery('.click-to-upload').removeClass('hidden');
                jQuery('.upload-list').addClass('hidden');
            }
        });
    }



    document.addEventListener('DOMContentLoaded', function() {
        HT.ckfinner();
        HT.setupCkedit();
        HT.upavt();
        HT.imgs();
        HT.changeLocationimg();
        HT.upalbum();
        HT.deleteinAlbum();
    });
})();
