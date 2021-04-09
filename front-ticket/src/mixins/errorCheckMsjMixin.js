export const errorCheckMsjMixin = {
  data() {
    return {
      fieldname: '',
      val: ''
    };
  },
  methods: {
    checkErr(fieldname, val,personalize = null) {
      // console.log("fieldname", fieldname)
      // console.log(!val.telefonoValidation)
      // console.log(val.hasOwnProperty("telefonoValidation"))
      // console.log("el value", val)
      if (personalize != null && !val.required){
        return fieldname
      }
      if (!val.$error) {
        return "";
      }
      if (val.hasOwnProperty("telefonoValidation") && !val.telefonoValidation) {
        return `Número de telefóno debe empezar con dígito 2.`;
      }
      if (val.hasOwnProperty("celularValidation") && !val.helper){
        return `Número de celular debe empezar con dígito 6 ó 7.`;
      }
      if (val.hasOwnProperty("minValue") && !val.minValue) {
        return `${fieldname} debe ser mayor que ${val.$params.minValue.min-1}.`;
      }
      if (val.hasOwnProperty("maxValue") && !val.maxValue) {
        return `${fieldname} debe ser menor que ${val.$params.maxValue.max}.`;
      }
      if (val.hasOwnProperty("between") && !val.between) {
        return `${fieldname} entre ${val.$params.between.min} y ${val.$params.between.max}.`;
      }
      if (val.hasOwnProperty("minLength") && !val.minLength) {
        return `${fieldname} debe contener  ${val.$params.minLength.min} carácteres.`;
      }
      if (val.hasOwnProperty("moneyValidation") && !val.helper){
        return `Escriba el Monto correctamente.`;
      }
      if (val.hasOwnProperty("emailValidation") && !val.helper){
        return `Digite un correo electrónico válido.`;
      }
      if (val.hasOwnProperty("email")) {
        return `Por favor, digite un correo electrónico válido.`;
      }
      if (val.hasOwnProperty("sameAsEmail")) {
        return `Correos electrónicos no son iguales.`;
      }
      if (val.hasOwnProperty("compararPassword") && !val.helper){
        return `La contraseña no es la misma.`;
      }
      if (val.hasOwnProperty("sameAsPassword")) {
        return `Contraseñas no son iguales.`;
      }
      if (val.hasOwnProperty("validarDUI") ){
        return `DUI no válido.`;
      }
      if (val.hasOwnProperty("validarNIT") ){
        return `NIT no válido.`;
      }
      if (val.hasOwnProperty("fechaValida") && !val.helper){
        return `La fecha no es válida.`;
      }
	   if (!val.required) {
        return `${fieldname} es requerido.`;
      }
    },
  },
  created() {
    this.checkErr(this.fieldname, this.val);
  }
};
