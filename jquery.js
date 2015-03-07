var suggest_count = 0;
var input_initial_value = '';
var suggest_selected = 0;
 
$(window).load(function(){
    // ������ ���� � ����������
    $("#search_box").keyup(function(I){
        // ���������� ����� �������� ����� ������ ��� ������� �� ����������
        switch(I.keyCode) {
            // ���������� ������� �� ��� �������
            case 13:  // enter
            case 27:  // escape
            case 38:  // ������� �����
            case 40:  // ������� ����
            break;
 
            default:
                // ���������� ����� ������ ��� ����� ����� 2� ��������
                if($(this).val().length>0){
 
                    input_initial_value = $(this).val();
                    // ���������� AJAX ������ � /ajax/ajax.php, �������� ��� GET query, � ������� �� �������� ��� ������
                    $.get("ajax.php", { "query":$(this).val() },function(data){
                        //php ������ ���������� ��� ������, �� ���� ���������� � ������.
                        // ������������ ������: ['test','test 1','test 2','test 3']
						
						var suggest_array = JSON.parse(data);
                        suggest_count = suggest_array.length;
                        if(suggest_count > 0){
                            // ����� ������� ���� ���������, ��� ��������
                            $("#search_advice_wrapper").html("").show();
							
                            for(var i = 0; i < suggest_count; i++){
                                if(suggest_array[i].name != ''){
                                    // ��������� ���� �������
                                    var div = document.createElement('div');
                                    div.className = 'advice_variant';
                                    div.setAttribute('client_id', suggest_array[i].id);
                                    div.textContent = suggest_array[i].name;
                                    document.getElementById('search_advice_wrapper').appendChild(div);
                                }
                            }
                        }
                    }, 'html');
                }
            break;
        }
    });
 
    //��������� ������� �������, ��� ����� ������ ���������
    $("#search_box").keydown(function(I){
        switch(I.keyCode) {
            // �� ������� ������� ������ ���������
            case 13: // enter
            case 27: // escape
                $('#search_advice_wrapper').hide();
                return false;
            break;
            // ������ ������� �� ��������� ����������� ����������
            case 38: // ������� �����
            case 40: // ������� ����
                I.preventDefault();
                if(suggest_count){
                    //������ ��������� ������� � ����, ������� �� ����������
                    key_activate( I.keyCode-39 );
                }
            break;
        }
    });
 
    // ������ ��������� ����� �� ���������
    $('.advice_variant').live('click',function(){
        // ������ ����� � input ������
        $('#search_box').val(this.textContent);
        //alert(this.getAttribute('client_id'));
        $('#clientID').val(this.getAttribute('client_id'));
		//$('#search_box').val($(this).text());
        // ������ ���� ���������
        $('#search_advice_wrapper').fadeOut(350).html('');
    });
 
    // ���� ������� � ����� ����� �����, ����� �������� ���������
    $('html').click(function(){
        $('#search_advice_wrapper').hide();
    });
    // ���� ������� �� ���� input � ���� ������ ���������, �� ���������� ������� ����
    $('#search_box').click(function(event){
        //alert(suggest_count);
        if(suggest_count)
            $('#search_advice_wrapper').show();
        event.stopPropagation();
    });
});
 
function key_activate(n){
    $('#search_advice_wrapper div').eq(suggest_selected-1).removeClass('active');
 
    if(n == 1 && suggest_selected < suggest_count){
        suggest_selected++;
    }else if(n == -1 && suggest_selected > 0){
        suggest_selected--;
    }
 
    if( suggest_selected > 0){
        $('#search_advice_wrapper div').eq(suggest_selected-1).addClass('active');
        $("#search_box").val( $('#search_advice_wrapper div').eq(suggest_selected-1).text());
        $("#clientID").val(document.getElementById('search_advice_wrapper').eq(suggest_selected-1).id);
    } else {
        $("#search_box").val(input_initial_value);
        $("#clientID").val('');
    }
}