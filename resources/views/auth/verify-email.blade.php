<style>
    body {
    background-color: #1f6521;
}
form {
    margin-top: 9px;
}
input[type="submit"] {
    background-color: #d6ce15;
    border-color: #007bff;
    display: inline-block; 
     font-weight: 400; 
    color: #212529;
    text-align: center; 
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
    .main-verification-input-wrap {
     max-width: 500px;
     margin: 20px auto;
     position: relative;
     margin-top: 129px
 }

 .main-verification-input-wrap ul {
     background-color: #fff;
     padding: 27px;
     color: #757575;
     border-radius: 4px
 }
 @media only screen and (max-width: 768px) {

 }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="main-verification-input-wrap">
            <ul>
                <li>You will recieve a verification email now on you registered email id. Please verify your email to continue</li>
                <li>If somehow, you did not recieve the verification email then 
                    <form action="{{ url('/email/verification-notification') }}" method="post">
                        @csrf
                        <input type="submit" value="resend the verification email" />
                    </form> 
                </li>
            </ul>
        </div>
    </div>
</div>