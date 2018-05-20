$(function() {
    var slider = $('.slider'),
        sliderContent = slider.html(),                      // Содержимое слайдера
        slideWidth = $('.slider-box').outerWidth(),         // Ширина слайдера
        slideCount = $('.slider img').length,               // Количество слайдов
        prev = $('.slider-box .prev'),                      // Кнопка "назад"
        next = $('.slider-box .next'),                      // Кнопка "вперед"
        sliderInterval = 3300,                              // Интервал смены слайдов
        animateTime = 1000,                                 // Время смены слайдов
        course = 1,                                         // Направление движения слайдера (1 или -1)
        margin = - slideWidth;                              // Первоначальное смещение слайдов

    $('.slider img:last').clone().prependTo('.slider');   // Копия последнего слайда помещается в начало.
    $('.slider img').eq(1).clone().appendTo('.slider');   // Копия первого слайда помещается в конец.
    $('.slider').css('margin-left', -slideWidth);         // Контейнер .slider сдвигается влево на ширину одного слайда.

    function nextSlide(){                                 // Запускается функция animation(), выполняющая смену слайдов.
        interval = window.setInterval(animate, sliderInterval);
    }

    function animate(){
        if (margin==-slideCount*slideWidth-slideWidth){     // Если слайдер дошел до конца
            slider.css({'marginLeft':-slideWidth});           // то блок .slider возвращается в начальное положение
            margin=-slideWidth*2;
        }else if(margin==0 && course==-1){                  // Если слайдер находится в начале и нажата кнопка "назад"
            slider.css({'marginLeft':-slideWidth*slideCount});// то блок .slider перемещается в конечное положение
            margin=-slideWidth*slideCount+slideWidth;
        }else{                                              // Если условия выше не сработали,
            margin = margin - slideWidth*(course);              // значение margin устанавливается для показа следующего слайда
        }
        slider.animate({'marginLeft':margin},animateTime);  // Блок .slider смещается влево на 1 слайд.
    }

    function sliderStop(){                                // Функция преостанавливающая работу слайдера
        window.clearInterval(interval);
    }

    prev.click(function() {                               // Нажата кнопка "назад"
        if (slider.is(':animated')) { return false; }       // Если не происходит анимация
        var course2 = course;                               // Временная переменная для хранения значения course
        course = -1;                                        // Устанавливается направление слайдера справа налево
        animate();                                          // Вызов функции animate()
        course = course2 ;                                  // Переменная course принимает первоначальное значение
    });
    next.click(function() {                               // Нажата кнопка "назад"
        if (slider.is(':animated')) { return false; }       // Если не происходит анимация
        var course2 = course;                               // Временная переменная для хранения значения course
        course = 1;                                         // Устанавливается направление слайдера справа налево
        animate();                                          // Вызов функции animate()
        course = course2 ;                                  // Переменная course принимает первоначальное значение
    });

    slider.add(next).add(prev).hover(function() {         // Если курсор мыши в пределах слайдера
        sliderStop();                                       // Вызывается функция sliderStop() для приостановки работы слайдера
    }, nextSlide);                                        // Когда курсор уходит со слайдера, анимация возобновляется.

    nextSlide();                                          // Вызов функции nextSlide()
});
$(function(){
    $("#display_product").dataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                }
            },
            "aoColumnDefs":[{
                "aTargets": [ 0 ]
                , "bSortable": false
            },{
                "aTargets":[ 2 ]
                , "bSortable": false
            }],
            "aria": {
                "sortAscending": ": активировать для сортировки столбца по возрастанию",
                "sortDescending": ": активировать для сортировки столбца по убыванию"
            }
    });
});
function displayTable()
{
    document.getElementById('display_product').style.display = 'block';
    document.getElementById('select_brand').style.display = 'none';
    document.getElementById('brand').style.display = 'none';
    document.getElementById('button1').style.display = 'none';
    document.getElementById('button2').style.display = 'none';
}

function setCoockies()
{
    var Post = $("#select_brand option:selected").text();
    document.cookie = "select="+Post;
}

function SetCoockies2()
{
    var Post2 = $("#brand option:selected").text();
    document.cookie = "select2="+Post2;
    document.location.reload(true);
}

function visibleInput()
{
    document.getElementById('display_product').style.display = 'none';
    document.getElementById('select_brand').style.display = 'display';
    document.getElementById('brand').style.display = 'display';
    document.getElementById('button1').style.display = 'display';
    document.getElementById('button2').style.display = 'display';

    document.location.reload(true);
}
function openForm(b, p){
    b.style.visibility = 'visible';
    p.style.visibility = 'visible';
    p.style.display = "block";

    var click = b.onclick();
    if(click == true) {
        closeForm(b, p);
    };
};

function validate(inputId){
    for(var e = 0; e < inputId.length; e++){
        var val = document.getElementById(inputId[e]).value;
        if (val != "") {
            var rightForm = true;
        } else {
            alert("Заполнены не все поля. Пожалуйста, введите недостающие данные!");
            rightForm = false;
            inputId[e].style.border = "border", "1px solid red";
            return false;
        };
    };
};
function closeForm(b, p) {
    if (confirm("Вы, действительно хотите закрыть форму? Введенные данные будут утеряны.")) {
        b.style.visibility = 'hidden';
        p.style.visibility = 'hidden';
    };
};