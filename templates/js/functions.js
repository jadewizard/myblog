action = "add";
/*Указываем, что первое действие - это
добавление поста*/

function addPost(userAction, id)
{
    alert(id);
    title = document.getElementById('postTitle').value;
    //Получаем заголовок
    text = tinyMCE.activeEditor.getContent();
    //Получаем текст
    postMessage = document.getElementById('postMessage');
    //Блок для ошибки

    if(userAction == "updateCreatedPost" && id !== '')
    {
        action = "updateCreatedPost";
        currentId = id;
        //Копируем переданный ID
    }
    else
    {
        currentId = undefined;
    }

    if(title != '')
    {
        if(text != '')
        {
            $.ajax
            ({
                type: "POST",
                url: "system/postaction.php",
                data:
                {
                    "postText": text,
                    "postTitle": title,
                    "action": action,
                    "id": currentId
                    //Текущее действие
                    //Add или Update или updateCreatedPost
                },
                success: function(data)
                {
                    action = "update";
                    /*Если скрипт (addpost.php) был успешно выполнен,
                    то значит, что пост добавлен в базу. Присваиваем
                    переменной action значение UPDATE, что бы
                    в дальншейм обновлять данный пост, а не добавлять
                    его снова.*/
                    document.getElementById('postAction').text = "Обновить";
                    //Меняем кнопку добавить на кнопку обновить
                    postMessage.innerHTML = '<div class="alert alert-dismissible alert-success">Пост успешно добавлен.</div>'
                    //Выводим сообщение об успешно добавление
                }
            });
        }
        else
        {
            postMessage.innerHTML = '<div class="alert alert-dismissible alert-danger">К сожалению опубликовать пустой пост нельзя!</div>';
        }
    }
    else
    {
        postMessage.innerHTML = '<div class="alert alert-dismissible alert-danger">Вы забыли написать заголовок!</div>';
    }

    console.log(action);
}

function deletePost(id)
{
    $.ajax
    ({
        type: "POST",
        url: "system/postaction.php",
        data:
        {
            "id": id,
            "action": "delete"
        },
        success: function()
        {
            document.getElementById('tr'+id).innerHTML = '';
            //Если пост был успешно удалён из БД, то удаляем блок
            //этого поста с страницы редактирования постов
        }
    });
}