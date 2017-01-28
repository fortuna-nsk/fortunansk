<?php
$data = "application/includes/txt/orders.txt"; ?>
<script type="text/javascript">
    $(function(){
        if($("form#order_send").attr("action") == ""){
            $("form#order_send .form-control").attr("disabled", "");
        }
        //отображение доп. полей взависимости от типа платежа
        $(document).on("change", "[name=order_type]", function(){
            var dataId = $(this).val(),
                anotherId = {"sber":"qiwi", "qiwi":"sber"};
            if(dataId != ""){
                ShowFields(anotherId[dataId], "[name=wallet_num]", 0);
                ShowFields(anotherId[dataId], "select", 0);
                ShowFields(anotherId[dataId], "textarea", 0);
                ShowFields(dataId, "select", 1);
            }else{
                ShowFields("sber", ":visible", 0);
                ShowFields("qiwi", ":visible", 0);
            }
            $("textarea").removeAttr("disabled");
        });
        $(document).on("change", "[name=order_place]", function(){
            var val = $(this).val();
            if(val == "wallet"){

                ShowFields("sber", "[data-name=wallet_num]", 0);
                ShowFields("qiwi", "[name=wallet_num]", 1);
                $("div[data-id=qiwi]").has("textarea").show();

            }else if(val == "terminal" || val == "euroset"){

                ShowFields("sber", "[data-name=wallet_num]", 0);
                ShowFields("qiwi", "[name=wallet_num]", 0);
                $("div[data-id=qiwi]").has("textarea").show();

            }else if(val == "mobil" || val == "lk" || val == "bankomat"){
                ShowFields("qiwi", "[name=wallet_num]", 0);
                ShowFields("sber", "[data-name=wallet_num]", 1);
                $("div[data-id=qiwi]").has("textarea").hide();
            }else{
                ShowFields("sber", "[data-name=wallet_num]", 0);
                ShowFields("qiwi", "[name=wallet_num]", 0);
                $("div[data-id=qiwi]").has("textarea").hide();
            }
        })
        $("#order_send").submit(function(e){
            if(parseInt($("[data-id=price]").val().replace(" ", "")) > 3000){
                e.preventDefault();
                alertify.error("Максимальная сумма к оплате 3 000р");
                $("[data-id=price]").focus();
            }else if($("[name=order_place]:required").val()==""){
                e.preventDefault();
                alertify.error("Отметьте все обязательные поля!");
                $("[name=order_place]:required").focus();
            }else if($("[data-id=sber_num]:visible").length > 0){
                if($("[data-id=sber_num]").val().match(/\d{4}/) == null){
                    e.preventDefault();
                    alertify.error("Укажите последнии цыфры карты");
                    $("[data-id=sber_num]").focus();
                }
            }
        })
    })

    function ShowFields(type, objStr, show){
        if(show == 0){
            $("div[data-id="+type+"]").has(objStr).hide();
            $("div[data-id="+type+"] "+objStr).removeAttr("required").attr("disabled", "");
        }else{
            $("div[data-id="+type+"]").has(objStr).show();
            $("div[data-id="+type+"] "+objStr).attr("required", "").removeAttr("disabled");
        }
    }
</script>
<?$form_visible =  intval($data[0]['order_access']) == 1 || intval($_SESSION['order_access']) == 1;?>
<?if($_SESSION['admin']==1){?>
    <script src="tmce4/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        tinymce.PluginManager.load('moxiecut', "/tmce4/plugins/moxiecut/plugin.min.js");
        tinymce.init({
            language: 'ru',
            selector: '#rules',
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor moxiecut'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
            height: 300,
        });
    </script>
<?}?>

<div class="col-xs-9">

    <legend>Отправка данных об оплате <?if($_GET["task"]=="login") echo "АН «".$data[1]."»";?></legend>
    <div class="col-xs-12" style="margin-top:15px">
        <?if($_SESSION['admin']==1){?>
            <?if(isset($_POST['content']) && $_GET['edit']==1){
                $fp = fopen($data, "wa"); // Открываем файл в режиме записи
                fwrite($fp, $_POST['content']); // Запись в файл
                fclose($fp); //Закрытие файла
            }?>
            <div data-id="text" class="hidden">
                <form method="post" action="?task=profile&action=order&edit=1">
                    <textarea id="rules" name="content"><?readfile($data)?></textarea>
                    <div class="col-xs-12" style="text-align: right;margin-top:15px">
                        <a href="?task=profile&action=order" class="btn btn-default">Отмена</a>
                        <button type="submit" class="btn btn-success">Отправить</button>
                    </div>
                </form>
            </div>
        <?}?>
        <div data-id="text">
            <?readfile($data);?>
            <?if($_SESSION['admin']==1){?>
                <div class="col-xs-12" style="text-align: right;margin-top:15px">
                    <button type="button" class="btn btn-primary" onClick="$('[data-id=text]').toggleClass('hidden')">Редактировать</button>
                </div>
            <?}?>
        </div>
    </div>