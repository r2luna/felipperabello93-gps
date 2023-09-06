/**
 * arquivo: tesouraria_deb_cred_v1.0.0.js
 * processo: - Tesouraria Solicitação de Crédito/Débito
 *
 *
 * @since       JAN/2023
 * @Author      Felippe Rabello
 *
 */

/* Etapas */
var Etapa = Object.freeze({
    COMPLEMENTAR_INFORMACOES: 1,
    SOLICITAR_NOTIFICACAO: 2,
    CANCELAR_SOLICITACAO: 3,
    REVISAR_NOTIFICACAO: 4,
    INSERIR_NOTIFICACAO_ASSINADA: 5,
    ENVIAR_PARA_ASSINATURA: 6,
    MINUTA_CHANCELADA_ELABORAR_FOLHA_DE_ROSTO: 7,
    CIENCIA_DA_NOTIFICACAO: 8,
    VERIFICAR_E_CADASTRAR_PARA_JURIDICO: 9,
});

/* Globais Auxiliares */
const codForm = ProcessData.processId;
const codVersao = ProcessData.version;
const codProcesso = ProcessData.processInstanceId;
const codEtapa = ProcessData.activityInstanceId;
const codCiclo = ProcessData.cycle;
const documentStore = Lecom.stores.DocumentStore;
const camposSolicitante = ["NOME_SOLICITANTE", "LT_CASA", "TELEFONE", "EMAIL", "RAMAL", "DES_DEPTO", "TIPO"];
const camposParte1 = ["T_CASA", "CNPJ_ME2", "ENDERECO2", "NUMERO", "BAIRRO", "CIDADE", "ESTADO", "CEP"];
const camposParte2 = ["NOME_NOTIFICADO2", "CNPJ_ME_NOTIFICADO2", "ENDERECO_NOTIFICADO2", "NUMERO_NOTIFICADO2", "BAIRRO_NOTIFICADO", "CIDADE_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "CEP_NOTIFICADO"];
const camposParte3 = ["ID_CONTRATO", "ID_ADITIVO"];
const camposParte4 = ["TIPO_RESCISAO", "MOTIVADA_DESC"];
const camposParte5 = ["AVISO_PREVIO_IMOTIVADA"];
const camposParte6 = ["PREVISAO_MULTA"];
const camposParte7 = ["MULTA_COBRADA_RSC"];
const camposParte8 = ["DEMAIS_OBS"];
const camposParte9 = ["DESC_DESCOMPRIMENTO", "DESCR_ANEXO", "ANEXO"];
const camposParte10 = ["DESC_TRATA_DE", "DESC_ANEXO_TRATA_SE", "ANEXO_TS"];

const labels = ['LBL_SOLICITANTE', "LBL_TIPO_NOTIFICACAO"];
const labelsParte = ['LBL_PARTE_I', 'LBL_PARTE_II', 'LBL_PARTE_III', 'LBL_PARTE_IV', 'LBL_PARTE_V', 'LBL_PARTE_VI', 'LBL_PARTE_VII', 'LBL_PARTE_VIII', "LBL_PARTE_VIV"];

/* Carregamento do Formulario */
$(document).ready(function () {
    console.clear();
    initForm();
    setForm();
    validaFormOnSubmit();
});

function validaFormOnSubmit() {

    if (Form.actions('aprovar')) {

        Form.actions('aprovar').subscribe('SUBMIT', function (itemId, action, reject) {

            console.log(codEtapa);

            switch (codEtapa) {

                case Etapa.SOLICITAR_NOTIFICACAO:

                    var tipo = Form.fields('TIPO').value()
                    if (tipo != undefined) {
                        var valor = Array.isArray(tipo) ? tipo[0] : tipo;
                        switch (valor) {
                            case 'Descumprimento Contratual':
                                if (!validaGrid("GRID_ANEXO")) {
                                    reject();
                                }
                                break;
                            case 'Notificação Extrajudicial':
                                if (!validaGrid("GRID_ANEXO_TS")) {
                                    reject();
                                }
                                break;
                            case 'Resposta de Notificação':
                                if (!validaGrid("GRID_ANEXO_TS")) {
                                    reject();
                                }
                                break;
                        }
                    }

                    break;


            }

        });

    }
    if (Form.actions('finish')) {

        Form.actions('finish').subscribe('SUBMIT', function (itemId, action, reject) {
            console.log(codEtapa);

            switch (codEtapa) {
                case Etapa.INSERIR_NOTIFICACAO_ASSINADA:
                    if (!validaGrid("GRID_ANEXO_ASS")) {
                        reject();
                    }
                    break;

            }
        });
    }
}

/* setup das etapas (inicialização) */
function initForm() {
    IniciarCampos();
    trataCamposTipoChamado();
    switch (codEtapa) {
        case Etapa.SOLICITAR_NOTIFICACAO:
            break;
        case Etapa.COMPLEMENTAR_INFORMACOES:
            break;
        case Etapa.INSERIR_NOTIFICACAO_ASSINADA:
            break;
        case Etapa.MINUTA_CHANCELADA_ELABORAR_FOLHA_DE_ROSTO:
            break;
    }
    Form.apply();
}

/* formatação das etapas */
function setForm() {
    switch (codEtapa) {
        case Etapa.SOLICITAR_NOTIFICACAO:
            addEventTipoChamado();
            break;
        case Etapa.COMPLEMENTAR_INFORMACOES:
            addEventTipoChamado();
            break;
        case Etapa.MINUTA_CHANCELADA_ELABORAR_FOLHA_DE_ROSTO:
            addEventTipoChamado();
            break;
        case Etapa.REVISAR_NOTIFICACAO:
            addEventTipoChamado();
            break;;
        case Etapa.VERIFICAR_E_CADASTRAR_PARA_JURIDICO:
            addEventTipoChamado();
        case Etapa.CIENCIA_DA_NOTIFICACAO:
            addEventTipoChamado();
            exibeCamposGrid(['GRID_ANEXO_NA']);
            var conteudoArr = [];
            var valor = "";

            $(".history__item-header").each(function () {
                valor = $(this).html();
                valor = valor.replace('<p tabindex="0">', "");
                valor = valor.replace('</p>', "");
                valor = valor + ": " + $(".history__description").html() + "\n";
                conteudoArr.push(valor);
            });

            Form.fields('DEMAIS_OBS_PDF').value(conteudoArr.join(""));
            Form.apply();
            break;
        case Etapa.ENVIAR_PARA_ASSINATURA:
            addEventTipoChamado();
            break;
        case Etapa.INSERIR_NOTIFICACAO_ASSINADA:
            addEventTipoChamado();
            break;

    }
    Form.apply()
}


function IniciarCampos() {

    camposInvisiveis(
        [
            //"T_CASA", "CNPJ_ME2", "ENDERECO2", "NUMERO", "BAIRRO", "CIDADE", "ESTADO", "CEP",
            //"NOME_NOTIFICADO2", "CNPJ_ME_NOTIFICADO2", "ENDERECO_NOTIFICADO2", "NUMERO_NOTIFICADO2", "BAIRRO_NOTIFICADO", "CIDADE_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "CEP_NOTIFICADO",
            //"ID_CONTRATO", "ID_ADITIVO",
            "TIPO_RESCISAO", "MOTIVADA_DESC",
            "AVISO_PREVIO_IMOTIVADA",
            "PREVISAO_MULTA",
            "MULTA_COBRADA_RSC",
            "DEMAIS_OBS",
            "DESC_DESCOMPRIMENTO",
            "DESC_TRATA_DE"
        ]
    );

    Form.fields('LBL_PARTE_I').label('NOTIFICANTE');
    Form.fields('LBL_PARTE_II').label('PARTE CONTRÁRIA / NOTIFICADA');
    Form.fields('LBL_PARTE_III').label('ID DO CONTRATO PRINCIPAL E EVENTUAIS ADITIVOS');
    Form.fields('LBL_PARTE_IV').label('A RESCISÃO SERÁ');
    Form.fields('LBL_PARTE_V').label('O AVISO PRÉVIO SERÁ');
    Form.fields('LBL_PARTE_VI').label('EXISTE PREVISÃO DE MULTA?');
    Form.fields('LBL_PARTE_VII').label('SERÁ COBRADA PELA RSC?');
    Form.fields('LBL_PARTE_VIII').label('DEMAIS OBSERVAÇÕES ADICIONAIS');
    Form.fields('LBL_PARTE_VIV').label('DESCRIÇÃO DETALHADA DO DESCUMPRIMENTO CONTRATUAL');


    ocultaCamposGrid(["GRID_ANEXO", "GRID_ANEXO_TS", "GRID_ANEXO_NA"]);

    ocultaLabels(['LBL_PARTE_IV', 'LBL_PARTE_V', 'LBL_PARTE_VI', 'LBL_PARTE_VII', 'LBL_PARTE_VIII', "LBL_PARTE_VIV"]);

    Form.fields('DEMAIS_OBS').value("");
    Form.apply();

}


function addEventTipoChamado() {
    Form.fields("TIPO").subscribe("CHANGE", function (formId, fieldId, resposta) {
        IniciarCampos();
        trataCamposTipoChamado();
        Form.apply();
    })
    Form.fields("TIPO_RESCISAO").subscribe("CHANGE", function (formId, fieldId, resposta) {
        trataCamposTipoChamado();
        Form.apply();
    });
    Form.fields("PREVISAO_MULTA").subscribe("CHANGE", function (formId, fieldId, resposta) {
        trataCamposTipoChamado();
        Form.apply();
    });
}



function HabilitaCampos() {
    camposInvisiveis(["JUSTIFICATIVA_N_ORCADO", "VALOR_ORCADO", "VALOR_DOCUMENTO"])
    var tipo = Form.fields('PREVISTO_ORCAMENTO').value()
    if (tipo != undefined) {
        var valor = Array.isArray(tipo) ? tipo[0] : tipo;
        switch (valor) {
            case 'Não se aplica':
                break;
            case 'Não orçado':
                Form.fields("JUSTIFICATIVA_N_ORCADO").visible(true).apply();
                break;
            case 'Sim':
                Form.fields("VALOR_ORCADO").visible(true).apply();
                Form.fields("VALOR_DOCUMENTO").visible(true).apply();
                break;
        }
    }
    Form.apply()
}


function getValorCampo(campo) {
    var valorCampo = Form.fields(campo).value();
    if (valorCampo != undefined) {
        var valor = Array.isArray(valorCampo) ? valorCampo[0] : valorCampo;
        return valor;
    }
}

function trataCamposTipoChamado() {
    var valor = getValorCampo('TIPO');
    switch (valor) {
        case 'Rescisão':

            exibeCamposObrigatorios(["T_CASA"])
            exibeCampos(
                [
                    "CNPJ_ME2", "ENDERECO2", "NUMERO", "BAIRRO", "CIDADE", "ESTADO", "CEP",
                    "NOME_NOTIFICADO2", "CNPJ_ME_NOTIFICADO2", "ENDERECO_NOTIFICADO2", "NUMERO_NOTIFICADO2", "BAIRRO_NOTIFICADO", "CIDADE_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "CEP_NOTIFICADO",
                    "ID_CONTRATO", "ID_ADITIVO",
                    "TIPO_RESCISAO",
                    "DEMAIS_OBS"
                ]
            );



            exibeLabels(['LBL_PARTE_I', 'LBL_PARTE_II', 'LBL_PARTE_III', 'LBL_PARTE_IV', 'LBL_PARTE_VIII']);
            var tipo = getValorCampo('TIPO_RESCISAO');

            switch (tipo) {
                case 'IMOTIVADA':
                    exibeLabels(['LBL_PARTE_V']);
                    exibeCampos(["AVISO_PREVIO_IMOTIVADA"]);

                    ocultaLabels(['LBL_PARTE_VI'])
                    camposInvisiveis(["PREVISAO_MULTA", "MOTIVADA_DESC"]);
                    break;


                case 'MOTIVADA':
                    exibeLabels(['LBL_PARTE_VI'])
                    exibeCampos(["PREVISAO_MULTA"]);
                    exibeCamposObrigatorios(["MOTIVADA_DESC"])

                    ocultaLabels(['LBL_PARTE_V']);
                    camposInvisiveis(["AVISO_PREVIO_IMOTIVADA"]);
                    var previsao = getValorCampo('PREVISAO_MULTA');

                    switch (previsao) {
                        case 'SIM':
                            exibeLabels(['LBL_PARTE_VII']);
                            exibeCampos(["MULTA_COBRADA_RSC"]);
                            break;


                        case 'NÃO':
                            ocultaLabels(['LBL_PARTE_VII']);
                            camposInvisiveis(["MULTA_COBRADA_RSC"]);
                            break;
                    }
                    break;
            }

            break;




        case 'Descumprimento Contratual':
            exibeCamposObrigatorios(["T_CASA"])
            exibeLabels(['LBL_PARTE_I', 'LBL_PARTE_II', 'LBL_PARTE_III', 'LBL_PARTE_VIII', 'LBL_PARTE_VIV']);
            exibeCampos(
                [
                    "CNPJ_ME2", "ENDERECO2", "NUMERO", "BAIRRO", "CIDADE", "ESTADO", "CEP",
                    "NOME_NOTIFICADO2", "CNPJ_ME_NOTIFICADO2", "ENDERECO_NOTIFICADO2", "NUMERO_NOTIFICADO2", "BAIRRO_NOTIFICADO", "CIDADE_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "CEP_NOTIFICADO",
                    "ID_CONTRATO", "ID_ADITIVO",
                    "DEMAIS_OBS"
                ]
            );
            exibeCamposObrigatorios(["DESC_DESCOMPRIMENTO"])


            exibeCamposGridObrigatorios(["GRID_ANEXO"]);

            break;
        case 'Notificação Extrajudicial':
            exibeCamposObrigatorios(["T_CASA", "DESC_TRATA_DE"]);
            exibeLabels(['LBL_PARTE_I', 'LBL_PARTE_II', 'LBL_PARTE_III', 'LBL_PARTE_VIII']);
            exibeCampos(
                [
                    "CNPJ_ME2", "ENDERECO2", "NUMERO", "BAIRRO", "CIDADE", "ESTADO", "CEP",
                    "NOME_NOTIFICADO2", "CNPJ_ME_NOTIFICADO2", "ENDERECO_NOTIFICADO2", "NUMERO_NOTIFICADO2", "BAIRRO_NOTIFICADO", "CIDADE_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "CEP_NOTIFICADO",
                    "ID_CONTRATO", "ID_ADITIVO",
                    "DEMAIS_OBS"
                ]
            );
            exibeCamposGridObrigatorios(["GRID_ANEXO_TS"]);
            break;
        case 'Resposta de Notificação':
            exibeCamposObrigatorios(["T_CASA", "DESC_TRATA_DE"]);
            exibeLabels(['LBL_PARTE_I', 'LBL_PARTE_II', 'LBL_PARTE_III', 'LBL_PARTE_VIII']);
            exibeCampos(
                [
                    "CNPJ_ME2", "ENDERECO2", "NUMERO", "BAIRRO", "CIDADE", "ESTADO", "CEP",
                    "NOME_NOTIFICADO2", "CNPJ_ME_NOTIFICADO2", "ENDERECO_NOTIFICADO2", "NUMERO_NOTIFICADO2", "BAIRRO_NOTIFICADO", "CIDADE_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "LS_ESTADO_NOTIFICADO", "CEP_NOTIFICADO",
                    "ID_CONTRATO", "ID_ADITIVO",
                    "DEMAIS_OBS"
                ]
            );
            exibeCamposGridObrigatorios(["GRID_ANEXO_TS"]);
            break;
    }

    Form.apply()
}

function camposInvisiveis(c) {
    c.forEach(function (campos) {
        Form.fields(campos).visible(false).apply()
        Form.fields(campos).setRequired('aprovar', false).apply()
    })
}




function camposFormInvisiveis() {
    campos.forEach(function (campo) {
        Form.fields(campo).visible(false).apply()
        Form.fields(campo).setRequired('aprovar', false).apply()
    })

    labels.forEach(function (lbl) {
        Form.fields(lbl).visible(false).apply()
    })
}

function desabilitarCampos(campos) {
    campos.forEach(function (campo) {
        Form.fields(campo).disabled(true).apply();
    })
}

function exibeCamposObrigatorios(campos) {
    campos.forEach(function (campo) {
        Form.fields(campo).visible(true).apply()
        Form.fields(campo).setRequired('aprovar', true).apply()
        //if (codEtapa != Etapa.SOLICITAR_NOTIFICACAO && codEtapa != Etapa.COMPLEMENTAR_INFORMACOES) {
        //     Form.fields(campo).readOnly(true).apply()
        //  }
    })
}

function ocultaCamposGrid(x) {
    x.forEach(function (grid) {
        Form.grids(grid).fields().forEach(function (campo) {
            Form.grids(grid).fields(campo.id).visible(false).apply()
            Form.grids(grid).fields(campo.id).setRequired(false).apply()
            Form.grids(grid).actions('EDIT').hidden(true).apply();
            Form.grids(grid).actions('DESTROY').hidden(true).apply();
        })
        Form.grids(grid).visible(false).apply()
    })
}

function exibeCamposGridObrigatorios(grids) {
    grids.forEach(function (grid) {
        Form.grids(grid).fields().forEach(function (campo) {
            Form.grids(grid).fields(campo.id).visible(true).apply()
            Form.grids(grid).fields(campo.id).setRequired(true).apply()
            if (codEtapa != Etapa.SOLICITAR_NOTIFICACAO && codEtapa != Etapa.COMPLEMENTAR_INFORMACOES) {
                Form.grids(grid).fields(campo.id).readOnly(true).apply()
                Form.grids(grid).actions('EDIT').hidden(true).apply();
                Form.grids(grid).actions('DESTROY').hidden(true).apply();
            }
        })
        Form.grids(grid).visible(true).apply()
    })
}

function exibeCamposGrid(grids) {
    grids.forEach(function (grid) {
        Form.grids(grid).fields().forEach(function (campo) {
            Form.grids(grid).fields(campo.id).visible(true).apply()
            Form.grids(grid).actions('EDIT').hidden(false).apply();
            Form.grids(grid).actions('DESTROY').hidden(false).apply();

        })
        Form.grids(grid).visible(true).apply()
    })
}

function exibeCampos(campos) {
    campos.forEach(function (campo) {
        Form.fields(campo).visible(true).apply()
        if (codEtapa != Etapa.SOLICITAR_NOTIFICACAO && codEtapa != Etapa.COMPLEMENTAR_INFORMACOES && campo != "DEMAIS_OBS") {
            Form.fields(campo).readOnly(true).apply()
        }
    })
}

//Função para mudar o label e o hidden do botão aprovar
function mudaBotaoAprovar(escondido, rotulo) {
    if (rotulo == undefined) {
        Form.actions("aprovar").hidden(escondido);
    }
    else {
        Form.actions("aprovar").label(rotulo).hidden(escondido);
    }
}

//Função para mudar o label e o hidden do botão rejeitar, que pode não existir
function mudaBotaoRejeitar(escondido, rotulo) {
    if (rotulo == undefined) {
        if (Form.actions("rejeitar"))
            Form.actions("rejeitar").hidden(escondido);
    }
    else {
        if (Form.actions("rejeitar"))
            Form.actions("rejeitar").label(rotulo).hidden(escondido);
    }

}

function exibeLabels(labels) {
    labels.forEach(function (lbl) {
        Form.fields(lbl).visible(true).apply()
    })
}

function ocultaLabels(labels) {
    labels.forEach(function (lbl) {
        Form.fields(lbl).visible(false).apply()
    })
}

function addJustificativaAvaliacaoAtend() {
    Form.fields("AVALIACAO_ATENDIMENTO").subscribe("CHANGE", function (formId, field, response) {
        var nota = Form.fields('AVALIACAO_ATENDIMENTO').value();
        Form.fields('JUSTIFICATIVA_ATEND').visible(nota != '4 - BOM' && nota != '5 - MUITO BOM')
        Form.apply();
    })
}


function validaGrid(grid) {
    if (!validaPreenchimentoGrid(grid)) {
        Form.grids(grid).errors('É necessário incluir ao menos um arquivo!').apply();
        return false
    }
    return true

}



function validaPreenchimentoGrid(identificadorGrid) {
    let grid = Form.grids(identificadorGrid);
    if (grid) {
        let gridItems = grid.dataRows();
        if (gridItems.length < 1) {
            return false;
        }
    }
    return true;

}
