$(function() {

    var load = new DV_general();
    load.load();
 
});

//Classes e Funções Gerais
function DV_general() {

    //pnotify
    $.pnotify.defaults.styling = "jqueryui";
    
    $.pnotify.defaults.history = false; 

    var toggle = new DV_toggle();

    var table = new DV_table();

    this.folder_path = 'painel';

    this.load = function() {
        var uri = new DV_uri();
        var url = new DV_url();
        var mask = new DV_mask();

        $(document).foundation();

        $('.botao-acao').on('dblclick', function(e) {
            e.eventeDefault();
        });

        $('.tabs').tabs();

        $('.buscaFornecedor').on('blur', function() {
            url.controller = 'CGeral';
            url.method = 'busca_fornecedor';

            if ($(this).val() !== '') {
                $.ajax({
                    type: 'post',
                    url: url.create(),
                    dataType: 'json',
                    data: {data: $(this).val()},
                    success: function(ret) {

                        var contador = ret.TIP_CGC_CPF.length;
                        var tamanho = 14;

                        if (ret.TIP_CGC_CPF.length != tamanho)
                        {
                            do
                            {
                                ret.TIP_CGC_CPF = "0" + ret.TIP_CGC_CPF;
                                contador += 1;

                            } while (contador < tamanho)
                        }

                        $('.dialogSystem input[name=T026_rms_cgc_cpf]').val(ret.TIP_CGC_CPF);
                        $('.dialogSystem input[name=T026_rms_codigo]').val(ret.TIP_CODIGO + ret.TIP_DIGITO);
                        $('.dialogSystem input[name=T026_rms_insc_est_ident]').val(ret.TIP_INSC_EST_IDENT);
                        $('.dialogSystem input[name=T026_rms_razao_social]').val(ret.TIP_RAZAO_SOCIAL);
                        $('.dialogSystem input[name=T026_rms_insc_mun]').val(ret.TIP_INSC_MUN);
                        $('.dialogSystem input:hidden[name=T026_codigo]').val(ret.T026_codigo);

                        url.controller = 'C0016';
                        url.method = 'combo_categoria_fornecedor';

                        $.ajax({
                            type: 'post',
                            url: url.create(),
                            dataType: 'json',
                            data: {cnpj: $('.cnpj').val()},
                            success: function(ret) {
                                $('.dialogSystem select[name=T120_codigo] option').remove();
                                $.each(ret, function(key, value) {
                                    $('.dialogSystem select[name=T120_codigo]').append('<option value="' + key + '">' + key + ' - ' + value + '</option>');
                                });
                            }
                        });

                        mask.init();
                    }
                });
            }
            ;
        });

        //Tooltip
        $('.customTooltip').tooltip();
        
        url.controller  =   'CGeral';
        url.method  =   'busca_usuario';
        $('.inputLogin').autocomplete({
            source: url.create()
        });
        
        //Input Login
        $('.inputLogin').click(function(){
            $(this).select();
        });
        
        $('.inputLogin').blur(function(){
            var regExp = /\(([^)]+)\)/;
            var matches = regExp.exec($(this).val());
            $(this).next('input[type=hidden]').val(matches[1]);
        });

        //Tradução datepicker
        $.datepicker.regional['pt-BR'] = {
            closeText: 'Fechar',
            prevText: '&#x3c;Anterior',
            nextText: 'Pr&oacute;ximo&#x3e;',
            currentText: 'Hoje',
            monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

        //Datepicker Custom
        $(".customDate").datepicker({
            showButtonPanel: true
        });
        
        //Timepicker Custom
        $(".customDatetime").datetimepicker();

        //para links/anchor() # não recarregar
        $('a.not-click').on('click', function(e) {
            e.preventDefault();
        });

        //Radioset
        $(".radioset").buttonset();

        //Accordion
        $(".accordion").accordion();

        //Oculta Filtros
        $('.ocultarFiltros').click(function() {

            var filter = $('#filters');

            if (filter.css('display') !== 'none')
                $('.ocultarFiltros').html('<span class="ui-icon ui-icon-triangle-2-n-s"></span>Mostrar Filtros');
            else
                $('.ocultarFiltros').html('<span class="ui-icon ui-icon-triangle-2-n-s"></span>Ocultar Filtros');

            toggle.obj = filter;
            toggle.effect = 'slide';
            toggle.toggle();

        });

        table.check_item();
        table.check_all();
        table.toggle_buttons();
        mask.init();
        
        //Esconde botão fechar dialogs
        $(".ui-dialog-titlebar-close").hide();
        
        //Atribui mascara para Valores R$
        $(".valor").maskMoney('mask'); 
        
    };
};

//Mensagens
function DV_message(){
    
    this.text           =   '';
    this.hide           =   false;
    this.height         =   'auto';
    this.width          =   '450';
    this.closer         =   false;
    this.sticker        =   false;
    this.history        =   false;
    this.shadow         =   false;
    this.animate_speed  =   100;
    this.opacity        =   .9;
    this.icon           =   false;
    this.stack          =   false;
    this.title          =   false;
    
    this.init = function(){
        
        tooltip =   $.pnotify({
            
                        title:          this.title,
                        text:           this.text,        
                        hide:           this.hide,
                        height:         this.height,
                        width:          this.width,
                        closer:         this.closer,
                        sticker:        this.sticker,
                        history:        this.history,
                        shadow:         this.shadow,
                        animate_speed:  this.animate_speed,
                        opacity:        this.opacity, 
                        icon:           this.icon,
                        stack:          this.stack,
                        after_init: function(pnotify) {
                            pnotify.mouseout(function() {
                                pnotify.pnotify_remove();
                            });
                        },
                        before_open: function(pnotify) {
                            pnotify.pnotify({
                                before_open: null 
                            });
                            return false;
                        }
                        
        });
    };
};

//Atribui mascaras nos campos
function DV_mask() {

    this.init = function() {

        $(".cnpj").mask('99.999.999/9999-99');
        $(".cpf").mask('999.999.999-99');
        $(".fone").mask('(99) 99999-9999');
        $(".cep").mask('99999-999');
        $(".rg").mask('99.999.999-9');
        $(".customDate").mask('99/99/9999');
        $(".customDatetime").mask('99/99/9999 99:99');
        $(".valor").maskMoney({
            symbol: 'R$ ', // Simbolo
            decimal: ',', // Separador do decimal
            precision: 2, // Precisão
            thousands: '.', // Separador para os milhares
            allowZero: false, // Permite que o digito 0 seja o primeiro caractere
            showSymbol: false    // Exibe/Oculta o símbolo
        });

    };

};

//Tabela
function DV_table() {

    var toggle = new DV_toggle();

    this.count_check = function() {

        var obj = $(".chkItm:checked");

        return obj.length;

    };

    this.check_all = function() {

        $("#chkAll").click(function() {
            if ($("#chkAll").is(':checked')) {
                $(".chkItm").prop("checked", true);
                toggle.toggle();
            } else {
                $(".chkItm").prop("checked", false);
                toggle.toggle();
            }
        });
    };

    this.toggle_buttons = function() {

        var obj = $(".no-multiple");

        toggle.obj = obj;
        toggle.effect = 'slide';

        if (this.count_check() == 1) {
            if (obj.css('display') == 'none') {
                toggle.toggle();
                toggle.attr_css();
            } else {
                return;
            }
        } else {
            toggle.toggle();
            toggle.attr_css();
        }

        obj = $(".multiple");

        toggle.obj = obj;
        toggle.effect = 'slide';

        if (this.count_check() >= 1) {
            if (obj.css('display') == 'none') {
                toggle.toggle();
                toggle.attr_css();
            } else {
                return;
            }
        } else {
            toggle.toggle();
            toggle.attr_css();
        }

    };

    this.check_item = function() {

        var toggle = new DV_table();

        $(".chkItm").on("click", function() {

            toggle.toggle_buttons();
//            this.attr_href();

        });
    };

    this.get_checkeds = function() {

        var arr_data = new Array();

        $.each($(".chkItm:checked"), function() {
            arr_data.push($(this).parents('tr').find('.idRef').text());
        });

        return arr_data;
    };

    this.get_checkeds_json = function() {

        var arr_data = new Array();

        $.each($(".chkItm:checked"), function() {
            arr_data.push($.parseJSON($(this).parents('tr').find('.arrRef').text()));
        });

        return arr_data;
    };

    this.display = function(option) {
        if (option == 'none') {
            var checkeds = this.get_checkeds();

            checkeds.css('display', 'none');
        }
        ;
    };
};

//Buttons
function DV_button(){
    
  this.class    =   new Array();  
  
  this.icon     =   new Array();
  
  this.title    =   new Array();
  
  this.create   =   function(){
      
      var html  =   '';
      
      var parent=   this;
      
      html  +=  '<ul id="icons" class="ui-widget ui-helper-clearfix" style="display:inline-block;">';
      
      var i =   0;
      $.each(this.icon, function(){
          
        html  +=  '<li class="ui-state-default ui-corner-all '+parent.class[i]+'" title="'+parent.title[i]+'"><span class="ui-icon ui-icon-'+parent.icon[i]+'"></span></li>';
        
        i++;
        
      });
      
      html  +=  '</ul>';
      
      return html;
      
  };
  
};


//Toggle
function DV_toggle() {

    this.obj = {};

    this.effect = '';

    this.options = {};

    this.attr_css = function() {

        $('.ui-effects-wrapper').css('height', '10');

    };

    this.toggle = function() {

        var options = {};
        $(this.obj).toggle(this.effect, this.options, 500);

    };

};

//Dialog
function DV_dialog() {

    var url = new DV_url();

    var parent = this;

    this.current = '';

    this.ret = '';

    this.width = 'auto';

    this.height = 'auto';

    this.title_program = $('#titleProgram').text()+' | ';

    this.title_dialog = '';

    this.buttons =
            [
                {
                    text: "Cancelar",
                    click: function() {
                        $(this).remove();
                    }
                }
            ];

    this.default_opening = function() {
        var load = new DV_general();
        load.load();
    };

    this.opening = function() {};

    this.closing = function() {
        $(".radioset").remove();
    };

    this.open = function(dados) {
        this.current = $(dados).dialog({
            autoOpen: true,
            open: function() {
                parent.default_opening();
                parent.opening();
            },
            close: this.closing,
            closeOnEscape: false,
            modal: true,
            resizable: false,
            draggable: false,
            dialogClass: 'dialogSystem',
            title: this.title_program + this.title_dialog,
            height: this.height,
            width: this.width,
            buttons: this.buttons
        });
    };

    this.msg = function(dados) {
        this.current = $(dados).dialog({
            autoOpen: true,
            open: function() {
                parent.default_opening();
                parent.opening();
            },
            close: this.closing,
            closeOnEscape: false,
            modal: true,
            resizable: false,
            draggable: false,
            dialogClass: 'dialogSystem',
            title: 'Mensagem!',
            height: 'auto',
            width: 'auto',
            buttons:[
                        {
                            text: "Fechar",
                            click: function() {
                                $(this).remove();
                            }
                        }
                    ]
        });
    };

    this.close = function() {
        $(this.current).remove();
    };

    this.send_form = function() {
        var parent = this;
        url.segment = parent.segment;

        var frm = $(parent.current).find('form');

        frm.find('input').removeAttr('disabled');
        frm.find('select').removeAttr('disabled');
            
        frm.submit(function(event) {

            var form = $(this);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serializeArray(),
                success: function(data) {
                    parent.validation(data);
                }
            });
            event.preventDefault(); //Prevenir o formulario ser enviado via browse.
        }).trigger('submit');

    };

    this.send_form_upload = function() {
        var parent = this;
        url.segment = parent.segment;

        var frm = $(parent.current).find('form');

        frm.submit();

    };

    this.redirect = function() {

        url.controller = this.controller;
        
        $(location).attr('href', url.create());

    };

    this.validation = function(data) {
        if (data == '1') {
            this.close();
            this.redirect();
        } else {
            this.close();
            this.open(data);
        }
    };

    this.buttons_tab = function() {

        var parent = this;

        parent.buttons.unshift
                ({text: 'Próximo'
                            , click: function() {
                        var next = $('.tabs').tabs("option", "active");
                        $('.tabs').tabs("option", "active", next + 1);
                        parent.buttons_tab();
                    }});

        parent.buttons.unshift
                ({text: 'Anterior'
                            , click: function() {
                        var prev = $('.tabs').tabs("option", "active");
                        $('.tabs').tabs("option", "active", prev - 1);
                        parent.buttons_tab();
                    }});

        if ($('.tabs').tabs("option", "active") == $(".ui-tabs-panel").size() - 1) {
            $('#next').remove();
        }

        if ($('.tabs').tabs("option", "active") == 0) {
            $('#prev').remove();
        }

    };

    this.diag_wkf = function() {

        $('.add_wkf').on('click', function() {

            var url_wkf = new DV_url();
            var diag_wkf = new DV_dialog();


            url_wkf.controller = 'CGeral';
            url_wkf.method = 'add_workflow';

            $.post(url_wkf.create(), function(dados) {
                var processo = $('input:hidden[name=T061_codigo]').val();
                var loja = $('select[name=T006_codigo]').val();
                var fornecedor = $('input:hidden[name=T026_codigo]').val();

                diag_wkf.title_dialog = 'Adicionar Workflow';

                diag_wkf.buttons.unshift
                        ({text: 'Salvar'
                                    , click: function() {

                                var frm = $(diag_wkf.current).find('form');

                                frm.submit(function(event) {

                                    var form = $(this);
                                    $.ajax({
                                        type: form.attr('method'),
                                        url: form.attr('action'),
                                        data: form.serializeArray(),
                                        dataType: 'json',
                                        success: function(ret) {

                                            diag_wkf.close();

                                            $.each($('select[name=T059_codigo]:last option'), function(key, option) {
                                                if ($(option).val() == '') {
                                                    $(this).remove();
                                                }
                                            });

                                            $('select[name=T059_codigo]:last').append('<option value="' + ret.T059_codigo + '">' + ret.T059_nome + '</option>');
                                            $('select[name=T059_codigo]:last option[value=' + ret.T059_codigo + ']').attr('selected', 'selected');
                                        }
                                    });
                                    event.preventDefault(); //Prevenir o formulario ser enviado via browse.
                                }).trigger('submit');

                            }});

                diag_wkf.open(dados);

                $('input:hidden[name=T061_codigo]:last').val(processo);
                $('input:hidden[name=T006_codigo]:last').val(loja);
                $('input:hidden[name=T026_codigo]:last').val(fornecedor);
            });

        });

    };

};

//URL
function DV_url() {

    this.controller = '';

    this.method = 'index';

    this.segment = '';

    this.create = function() {

        var general = new DV_general();

        var url = location.href;

        var start = url.indexOf('//');
        if (start < 0)
            start = 0;
        else
            start = start + 2;

        var end = url.indexOf('/', start);
        if (end < 0)
            end = url.length - start;

        var base_url = url.substring(start, end);

        if (this.segment)
            return 'http://' + base_url + '/' + general.folder_path + '/' + this.controller + '/' + this.method + '/' + this.segment;
        else if (this.method)
            return 'http://' + base_url + '/' + general.folder_path + '/' + this.controller + '/' + this.method;
        else
            return 'http://' + base_url + '/' + general.folder_path + '/' + this.controller;

    };

};

//List
function DV_list() {

    var url = new DV_url();

    this.obj = {};

    this.track = false;

    this.confirm = false;

    this.remove_item = function(obj) {

        $('.optionList').on('dblclick', function() {
            var $this = $(this);
            var list = new DV_list();
            var diag_confirm = new DV_dialog();
            var html = '<div class="row"><div>Tem certeza que deseja excluir ' + $this.val() + '?</div></div>';
            if (list.confirm) {
                diag_confirm.buttons.unshift
                        ({text: 'Excluir'
                                    , click: function() {
                                $this.remove();
                            }});
                diag_confirm.open(html);
            } else {
                $this.remove();
            }

        });

    };

    this.add_item = function(data) {

        var parent = this;
        var list = parent.obj;
        var input = list.find('input');

        if (data !== '0') {
            var label = data.T004_nome + ' (' + data.T004_login + ')  (novo)';
            var html = '<option value="' + label + '" class="optionList">' + label + '</option>';
            list.find('select').prepend(html);
            input.val('');
            input.focus();
        } else {
            alert('entrei em 0');
        }

    };

    this.data_exists = function(data, method) {
        url.method = method;

        var parent = this;

        $.ajax({
            dataType: 'json',
            type: 'post',
            url: url.create(),
            data: {data: data},
            success: function(data) {
                parent.add_item(data);
            }
        });

    };

    this.init = function(method) {

        var parent = this;

        //Ao pressionar enter no text
        $("input[name='inputList']").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                parent.data_exists($(this).val(), method);
            }
        });

        //Autocomplete
        url.controller = 'CGeral';
        url.method = method;
        $(".autocomplete").autocomplete({
            source: url.create()
        });

        //Botao Add
        $('.buttonList').click(function(e) {
            e.preventDefault();
            var input = $(this).parents('.list').find('input');
            parent.data_exists(input.val(), method);

            $('.listUser option').on('click', function() {
                alert('teste');
            });
        });



    };

    this.select = function() {

        $(obj + ' option').prop('selected', 'selected');

    };

};

//Post
function DV_post() {

    var url = new DV_url();

    this.controller = 'CGeral';

    this.method = '';

    this.data = '';

    this.post = function() {

        url.controller = this.controller;
        url.method = this.method;

    };

};

//Captura Controller, Metodo e Segmento
function DV_uri() {

    var url = new DV_url();

    this.controller = 'CGeral';

    this.ret = '';

    //Current controller
    this.get_controller = function() {

        $.post('http://intranet1.grupodavo.davo.com.br/painel/C0004/editar', function(data) {



            parent.ret = data;
        });
    };

    this.get_method = function() {

        var parent = this;

        url.controller = this.controller;

        url.method = 'get_method';

        $.post(url.create(), function(data) {

            parent.ret = data;
        });
    };

    this.get_segment = function(segment) {

        var parent = this;

        url.controller = this.controller;

        url.method = 'get_segment';

        url.segment = segment;

        $.post(url.create(), function(data) {

            parent.ret = data;

        });
    };
};
