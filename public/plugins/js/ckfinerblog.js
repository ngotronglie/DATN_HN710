(function($) {
    "use strict";
    var HT = {};

    //truy cap ckedit
    HT.setupCkedit = () =>{
        if ($('.ckedit')) {
            ($('.ckedit')).each(function(){
                let edit = $(this)
                let id = edit.attr('id')
                HT.Ckedit(id)
            })
        }
    }

    //thu vien ckedit
    HT.Ckedit = (id) =>{
        CKEDITOR.replace(id, {
        height: 270, // Chiều cao của trình soạn thảo
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

    HT.upavt = () => {
        $('input[name="img_avt"]').on('change', function() {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-target').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    };

    //upload nhieu anh
    HT.imgs = () => {
        $('.mutiimg').click(function(e){
            let object = $(this);
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
    document.addEventListener('DOMContentLoaded', function() {
        HT.setupCkedit();
        HT.upavt();
        HT.imgs();
    });
})(jQuery);
