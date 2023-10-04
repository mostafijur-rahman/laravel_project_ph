@push('js')
<script>
    function uniqueChallanValidation(){
        let challanNumber = document.getElementById("challan_number").value;
        $.ajax({
            type:'GET',
            url:'/trips/unique-challan-validation/' + challanNumber,
            success:function(data){

                // reset field
                document.getElementById("challan_number").className = "form-control";
                document.getElementById("validationMessage").className = "";
                document.getElementById("validationMessage").innerHTML = "";

                if(data.status){

                    document.getElementById("challan_number").className += " is-valid";
                    document.getElementById("validationMessage").className = "valid-feedback";
                    document.getElementById("validationMessage").innerHTML = <?php echo json_encode(__('cmn.you_can_use_it')); ?>;

                } else {

                    document.getElementById("challan_number").className += " is-invalid";
                    document.getElementById("validationMessage").className = "error invalid-feedback";
                    document.getElementById("validationMessage").innerHTML = <?php echo json_encode(__('cmn.challan_number_already_exists')); ?>;

                }
            },
            error:function(data){
                console.log(data);
            }
        });
    }
</script>
@endpush