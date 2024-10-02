(function() {
    "use strict";
    var HT = {};

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
        height: 260, // Chiều cao của trình soạn thảo
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
                html+= '<div><figure>'
                html+='<img src="'+src+'" alt="'+src+'" style="width:100%">'
                html+='<figcaption>Nhập mô tả hình ảnh</figcaption>'
                html+='</figure></div>'
            }
            

            CKEDITOR.instances[target].insertHtml(html);
        };
         finder.popup();
    }

    document.addEventListener('DOMContentLoaded', function() {
        HT.setupCkedit();
        HT.imgs();
    });
})();
