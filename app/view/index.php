
<!DOCTYPE html>
<html lang="ua">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="app/source/css/style.css">
    <script src="<?=Path::Source?>/js/jquery-3.1.1.min.js"></script>
</head>
<body>
<a href="/auth/logout">Logout</a>
<div class="container messages">
    <div class="row">
        <?php
        $user = new User();
        $currentUser = $user->getCurrent();
        foreach ($data as $row):
            if($row['arr']['text'] == ''){
            continue;
            }
            $res = $user->get('id="'.$row['arr']['user'].'"');
        ?>
        <div class="message">
            <div class="wrap">

                <div class="content">
                    <div class="name">
                        <h3>
                            <?=$res['name']?>
                        </h3>
                    </div>
                    <div class="text">
                       <?=$row['arr']['text']?>
                    </div>
                </div>
                <?php
                if($currentUser['id'] == $res['id']){
                    ?>
                    <a class="edit" data-id="<?=$row['arr']['id']?>" href="?edit=<?=$row['arr']['id']?>">edit</a>
                    <a class="delete" data-id="<?=$row['arr']['id']?>" href="/index/delete/<?=$row['arr']['id']?>">delete</a>
                    <?php
                }else{
                ?>
                <a class="comment" data-comment="<?=$row['arr']['id']?>" href="?comment=<?=$row['arr']['id']?>">comment</a>
                <?php
                }
                ?>
            </div>

        </div>
            <?php
            if($row['comments'] != array()):
                foreach ($row['comments'] as $r):
                    $res = $user->get('id="'.$r['user'].'"');
                ?>
                    <div class="message comment">
                        <div class="wrap">

                            <div class="content">
                                <div class="name">
                                    <h3>
                                        <?=$res['name']?>
                                    </h3>
                                </div>
                                <div class="text">
                                    <?=$r['text']?>
                                </div>
                            </div>
                            <?php
                            if($currentUser['id'] == $res['id']){
                            ?>
                            <a class="edit" data-id="<?=$row['arr']['id']?>" href="?edit=<?=$row['arr']['id']?>">edit</a>
                            <a class="delete" data-id="<?=$row['arr']['id']?>" href="/index/delete/<?=$row['arr']['id']?>">delete</a>
                            <?php
                            }?>
                        </div>

                    </div>


        <?php
            endforeach;
        endif;
        endforeach;
        ?>
    </div>
</div>

<div class="container message-input">
    <div class="row">
        <div class="message-row">
            <form method="post" action="/">
                <div class="row" style="padding: 15px;">
                    <div class="col-md-2" style="height: 70px;">
                        <button type="button" id="refresh" class="btn btn-default" style="height: 100%;width: 100%;">refresh</button>
                    </div>
                    <div class="col-md-8">
                        <textarea name="text" id="text" class="form-control" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="edit" id="edit" value="<?php if(isset($_GET['edit'])) echo $_GET['edit']; else echo 0;?>">

                    <input type="hidden" name="parent" id="parent" value="<?php if(isset($_GET['comment'])) echo $_GET['comment']; else echo 0;?>">
                    <div class="col-md-2" style="height: 70px;">
                        <button type="submit" class="btn btn-default" style="height: 100%;width: 100%;">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        $('#refresh').click(function () {
            $.ajax({
                url: "/ajax/index",

                success: function( result ) {
                    $('#parent').val(0);
                    $('.container.messages').html(result);
                }
            });
        });
        $('a.delete').click(function (e) {
            e.preventDefault();
            var id =  $(this).attr('data-id');
            $.ajax({
                url: "/ajax/index/delete",
                method:'post',
                data: {
                    id:id

                },
                success: function( result ) {
                    $.ajax({
                        url: "/ajax/index",

                        success: function( result ) {
                            $('#parent').val(0);
                            $('.container.messages').html(result);
                        }
                    });
                }
            });
        });
        $('a.comment').click(function (e) {
            e.preventDefault();
            var id = $(this).attr('data-comment');
            $('#parent').attr('value',id);
        });
        $('a.edit').click(function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $('#text').html($(this).parent().find('.text').html());
            $('#edit').attr('value',id);
        });
       $('form').submit(function () {
            var parent = $('#parent').val();
            var text = $('#text').val();
            var edit = $('#edit').val();
           if(edit == 0){
               $.ajax({
                   url: "/ajax/index",
                   method:'post',
                   data: {
                       text: text,
                       parent:parent
                   },
                   success: function( result ) {
                       $('#parent').val(0);
                       $('.container.messages').html(result);
                   }
               });
           }else{
               $.ajax({
                   url: "/ajax/index/edit",
                   method:'post',
                   data: {
                       id:edit,
                       text: text,

                   },
                   success: function( result ) {
                       $.ajax({
                           url: "/ajax/index",

                           success: function( result ) {
                               $('#parent').val(0);
                               $('.container.messages').html(result);
                           }
                       });
                   }
               });
           }

           return false;
       });
    });
</script>