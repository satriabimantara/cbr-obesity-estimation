$(document).ready(function () {
    $("#inputJumlahDataLatih").on('change keyup',function(){
        const persentase_data_latih = $(this).val();
        $('#inputJumlahDataUji').val('');
        if (persentase_data_latih>=70 && persentase_data_latih<= 100) {
            // ubah value pada data uji
            $('#inputJumlahDataUji').val(100-persentase_data_latih);
        }
    });
    $('.btn-reviseKasusBaru').on('click',function(){
        const id = $(this).data('id');
        $.ajax({
			url: 'http://localhost/cbr/public/data/getKasusBaru',
			data: {id : id},
			method: 'post',
			dataType: 'json',
			success: function(data){
                data = data[0];
                $('#id_kasusbaru_original').val(data.id_kasusbaru_original);
                $('#gender').val(data.gender);
                $('#age').val(data.age);
                $('#height').val(data.height);
                $('#weight').val(data.weight);
                $('#FHO').val(data.FHO);
                $('#FAVC').val(data.FAVC);
                $('#FCVC').val(data.FCVC);
                $('#NCP').val(data.NCP);
                $('#CAEC').val(data.CAEC);
                $('#SMOKE').val(data.SMOKE);
                $('#CH2O').val(data.CH2O);
                $('#SMOKE').val(data.SMOKE);
                $('#SCC').val(data.SCC);
                $('#FAF').val(data.FAF);
                $('#TUE').val(data.TUE);
                $('#CALC').val(data.CALC);
                $('#MTRANS').val(data.MTRANS);
			}
		});
    });
});