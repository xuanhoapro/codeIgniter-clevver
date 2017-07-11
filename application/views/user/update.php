<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="messages"></div>
            <form class="form-horizontal" method="post" id="frm_update_user">
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="inputName" placeholder="Name"
                               value="<?php echo $userObj->name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email"
                               value="<?php echo $userObj->email; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?php echo base_url('user') ?>" class="btn btn-default">Back to list</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>
<script type="text/javascript">
    // override jquery validate plugin defaults
    $.validator.setDefaults({
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    $(document).ready(function () {
        $('#frm_update_user').validate({
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        var btnSpan = $('<span aria-hidden="true">').html('&times;');
                        var btn = $('<button type="button" class="close" data-dismiss="alert" aria-label="Close">');
                        btn.append(btnSpan);
                        if (response.hasError) {
                            var msg = $('<div class="alert alert-danger alert-dismissable">').append(btn);
                            $.each(response.errors, function (index, error) {
                                msg.append(error + '<br>');
                            });
                        } else {
                            var msg = $('<div class="alert alert-success alert-dismissable">').append(btn);
                            msg.append('<strong>' + response.msg + '</strong>');

                        }
                        $('#messages').html(msg);
                    }
                });
            },
            rules: {
                name: {
                    required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                name: "Please enter your name",
                email: "Please enter a valid email address"
            },
        });
    });
</script>
