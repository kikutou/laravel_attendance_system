//すべてのcheckboxを選択。
$(function(){
    $('#all_users').click(function() {
        if(this.checked) {
            $(':checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });
})
$(function(){
    $(':checkbox').not('#all_users').click(function(){
        var count =  0;
        var len = $(':checkbox').length-1;
        $(':checkbox').not('#all_users').each(function(){
            if(!this.checked){
                $('#all_users').prop('checked',false);
            } else {
                count++;
            }
            if(count == len){
                $('#all_users').prop('checked',true);
            }
        });
    });
})
