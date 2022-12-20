<div class="row">
    <div class="col-md-4 mx-auto shadow bg-white px-3 pt-3">
        <h4 class="text-center confirmation"> Thanks for subscription </h4>
        <p class="text-dark message">Hi , thanks for subscription we are notify you for our latest news.</p>
        <p class="message">You have received below enquiry from <span class="url"> <p>{{ $email }}</p>Firm-tech.com</span></p>
        <p class="text-center text-success url">Regards: lms.com.pk </p>
        <p class="text-center text-success url"><a href="{{ url('un-subscribe/'. $email) }}">Unsubcribe</a></p>
    </div>
</div>
<style>
    .confirmation {
        color: brown;
        text-align: center
    }

    .url {
        color: green;
        text-align: center;
    }

    .message {
        text-align: center;
    }
</style>
