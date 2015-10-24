action = "add";
/*Указываем, что первое действие - это
добавление поста*/

function addPost(userAction)
{
    title = document.getElementById('postTitle').value;
    //Получаем заголовок
    text = tinyMCE.activeEditor.getContent();
    //Получаем текст
    errMsg = document.getElementById('errMsg');
    //Блок для ошибки

    if(userAction == "updateCreatedPost")
    {
        action = "updateCreatedPost";
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
                    "action": action
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
                }
            });
        }
        else
        {
            errMsg.innerHTML = '<div class="alert alert-dismissible alert-danger">К сожалению опубликовать пустой пост нельзя!</div>'
        }
    }
    else
    {
        errMsg.innerHTML = '<div class="alert alert-dismissible alert-danger">Вы забыли написать заголовок!</div>';
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