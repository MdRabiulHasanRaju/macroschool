const GetID = (id) => document.getElementById(id);
const formData = (input) => input.value;

let alertMessage = GetID("alertMessage");
let offer_price = GetID("offer_price");
let coupon_submit = GetID("coupon_submit");
let coupon_form = GetID("coupon_form");
let couponRemoveBtn1 = GetID("couponRemoveBtn1");
let all_input = [...(document.getElementsByClassName('input-form'))];


const  couponFormHandler = (e) => {
    e.preventDefault();

					
    let coupon_course_id = GetID("coupon_course_id").value;
    
    let coupon_code = GetID("coupon_code").value;
    

    let ajax = new XMLHttpRequest();

    ajax.open('POST','/macroschool/controllers/couponFormController.php',true);

    ajax.onprogress = function(){
        
    }

    ajax.onload = function(){
        if(ajax.status==200){
            let obj = JSON.parse(this.responseText);
            alertMessage.innerHTML = obj.success;
            let change_offer_price = offer_price.childNodes[0].data-obj.discount;
            offer_price.innerHTML = change_offer_price;
            alertMessage.style.color = '#1578c1';
            alertMessage.style.fontWeight = 'bold';
            alertMessage.style.fontSize = '13px';
            all_input[1].value="";
            coupon_form.style.display = "none"
            document.cookie = `offer_price=${change_offer_price}; max-age=86400; path=/`;
            document.cookie = `offer_price_id=${coupon_course_id}; max-age=86400; path=/`;
            document.cookie = `coupon_code=${coupon_code}; max-age=86400; path=/`;
            document.cookie = `discount_price=${obj.discount}; max-age=86400; path=/`;
            couponRemoveBtn1.style.display="block";
        }
        if(ajax.status==403){
            console.log(this.responseText)
            let obj = JSON.parse(this.responseText);
            alertMessage.innerHTML = obj.err;
            alertMessage.style.color = 'red';
            alertMessage.style.fontWeight = 'bold';
            alertMessage.style.fontSize = '12px';
            all_input[1].value="";
        }
    }

    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');

    let data = 'coupon_course_id='+coupon_course_id+'&coupon_code='+coupon_code;

    ajax.send(data);
 
};
  
if(coupon_form) coupon_form.addEventListener("submit", couponFormHandler);
