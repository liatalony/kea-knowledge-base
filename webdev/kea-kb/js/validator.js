// ##############################
function validate(){
  console.log("1");
    var elements_to_validate = all("[data-validate]")
    elements_to_validate.forEach(function(element){ element.classList.remove("validate_error") })
    elements_to_validate.forEach( function(element){
      switch(element.getAttribute("data-validate")){
        case "str":
          if( element.value.length < 2
          ){
            element.classList.add("validate_error")
          }
        break;  
        case "email":
          const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          if( ! re.test(element.value.toLowerCase()) ){
            element.classList.add("validate_error")
          }
        break;
        case "pass": 
        // Checks if the password contains at least one number, lowercase letter, uppercase letter and special character.
        // The first if statement is due to the fact that the check did not work when not in an if statement. ¯\_(ツ)_/¯
           if (element.value !="") {
            const re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}/;
            if (!re.test(element.value)) {
              element.classList.add("validate_error")
            }
          }
        break;
        case "con_pass":
            if( element.value != one("[data-validate=pass]").value ){
              element.classList.add("validate_error")
            }
          break;
      }
    })
  
    return one(".validate_error", event.target) ? false : true
  }
  
  // ##############################
  function clear_validate_error(){
    event.target.classList.remove("validate_error")
  }
  
  // ##############################
  function one(q, from=document){ return from.querySelector(q) }
  function all(q, from=document){ return from.querySelectorAll(q) }
  
  
  
  
  
  
  
  
  
  
  
  