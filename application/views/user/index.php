<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="messages"></div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered dataTable no-footer" id="list_user">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete this user?</p>
                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">

                <form id="submit-delete-item" action="<?php echo base_url('user/destroy') ?>" method="post">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="hidden" name="id" id="userId">
                    <button class="btn btn-danger btn-ok">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var tableUser = $('#list_user').DataTable({
            "autoWidth": true,
            "bLengthChange": false,
            "searching": false,
            "sort": false,
            "bFilter": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": decodeURIComponent('<?php echo base_url('user')?>'),
                "type": "GET",
                "data": function (d) {
                    d.page = d.start / d.length + 1;
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "email"},
                {"data": "created_at"},
                {"data": "id"}
            ],
            "pageLength": parseInt(<?php echo $itemPerPage ?>),
            "columnDefs": [
                {
                    'orderable': false,
                    "render": function (data, type, row) {
                        var divBtn = $('<div class="btn-group center-block">');
                        var linkEdit = $('<a>')
                            .attr('href', '<?php echo base_url('user/update')?>/' + data)
                            .html('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit');
                        var linkDelete = $('<a>')
                            .attr('href', '#')
                            .attr('onclick', 'event.preventDefault();')
                            .attr('data-toggle', 'modal')
                            .attr('data-target', '#confirm-delete')
                            .attr('data-uid', data)
                            .html('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete');

                        divBtn.append(linkEdit).append('&nbsp;&nbsp;&nbsp;&nbsp;').append(linkDelete);
                        return divBtn.prop('outerHTML');
                    },
                    "targets": 4
                }
            ],
        });

        $('#confirm-delete').on('show.bs.modal', function (e) {
            var data = $(e.relatedTarget).data();

            $('#userId').val(data.uid);
            $('.btn-ok', this).data('uid', data.uid);
        });

        $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            $modalDiv.addClass('loading');
            var id = $(this).data('uid');
            var urlAjax = decodeURIComponent('<?php echo base_url('user/destroy')?>');

            $.ajax({
                url: urlAjax,
                type: 'post',
                data: {'id': id},
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
                        $modalDiv.modal('hide').removeClass('loading');
                        var msg = $('<div class="alert alert-success alert-dismissable">').append(btn);
                        msg.append('<strong>' + response.msg + '</strong>');

                    }
                    $('#messages').html(msg);
                    tableUser.ajax.reload();
                }
            });

            return false;
        });
    });

</script>
