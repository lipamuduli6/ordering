<style>
    #uni_modal .modal-footer{
        display:none;
    }
</style>
<?php
session_start();
require_once("DBConnection.php");
?>
<div class="container-fluid">
    <form action="" id="place-order">
        <input type="hidden" name="total_amount" value="<?php echo $_GET['total'] ?>">
        <div class="form-group">
            <label for="" class="control-label">Delivery Address</label>
            <textarea name="delivery_address" id="delivery_address" cols="30" rows="3" class="form-control rounded-0"><?php echo $_SESSION['address'] ?></textarea>
        </div>
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-sm btn-primary rounded-0 me-1">Place Order</button>
                <button class="btn btn-sm btn-dark rounded-0" type="button" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
    $(function(){
        $('#place-order').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            _this.find('button').attr('disabled',true)
            $.ajax({
                url:'Actions.php?a=place_order',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                    _this.find('button').attr('disabled',false)
                    _this.find('button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.replace("./")
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                    _this.find('button').attr('disabled',false)
                    _this.find('button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>