

/***  Validate fields  ***/
const inputFullName = document.getElementById('name');
const inputEmail = document.getElementById('email');
var fullName = document.getElementById('fullName');
var contentAlert = $('#content-alert');
var alertCertificate = $('#alert-certificate');
//var validatorEmail = RegExp("^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$");
var validatorEmail = RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$");


inputFullName.oninput = () => {
    validateFieldName();

    if ( inputFullName.value === '' ) {
        fullName.innerText = 'Tu Nombre'; 
    } else {
        fullName.innerText = inputFullName.value;
    }
};

inputEmail.oninput = () => { validateFieldEmail(); }


const validateFieldName = () => {
    if (inputFullName.value === '') {
        document.getElementById('name-valid').innerText = 'El Nombre es requerido.';
        return false;
    } else {
        document.getElementById('name-valid').innerText = '';
    }

    return true;
}

const validateFieldEmail = () => {   
    let email = inputEmail.value;

    if ( email === '' ) {
        document.getElementById('email-valid').innerText = 'El Correo electrónico es requerido.';
        return false;
    } else {
                
        if ( validatorEmail.test(email) ) {
            document.getElementById('email-valid').innerText = '';
        } else {
            document.getElementById('email-valid').innerText = 'Ingrese un correo valido';
            return false;
        }
    }

    return true;
}


/***  Generate PDF  ***/
const btnGeneratePDF = document.getElementById('btn-generate');

btnGeneratePDF.addEventListener('click', () => {
    if ( validateFieldName() && validateFieldEmail() ) {
        verificateData();
    } 
});


const verificateData = () => {
    let dataUser = {
        'name': inputFullName.value,
        'email': inputEmail.value
    };

    $.ajax({
        url: 'https://backend.congresopalmadeaceite.com/api/insert-data-certificate',
        type: "POST",
        data: dataUser,
        success: function (response) {
            console.log('response: ', response)  
            if ( response.status === 'ok' ) {
                contentAlert.removeClass('alert-danger');
                contentAlert.addClass('alert-success');
                generateCertifidatePDF();
            } else {
                contentAlert.removeClass('alert-success');
                contentAlert.addClass('alert-danger');
            }
            contentAlert.text(response.msg);
            alertCertificate.show();          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error... ',textStatus, errorThrown);
        }
    });
}


const generateCertifidatePDF = () => {

    const elementoParaConvertir = document.getElementById('content'); // <-- Aquí puedes elegir cualquier elemento del DOM

    html2pdf()
        .set({
            margin: 0,
            filename: 'Certificado.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 3, // A mayor escala, mejores gráficos, pero más peso
                letterRendering: true,
            },
            jsPDF: {
                unit: "mm",
                format: "letter",
                orientation: 'landscape' // landscape o portrait
            }
        })
        .from(elementoParaConvertir)
        .save()
        .catch(err => console.log(err))
        .then(() => { console.log('creando pdf...') });
}