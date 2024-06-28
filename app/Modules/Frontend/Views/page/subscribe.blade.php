


@extends('Frontend::layouts.master')

@section('title', __('pricing'))
<!-- @section('class_body', 'page contact-us') -->

@push('css')
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/solid.css">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Rubik&display=swap');

  /* #########    Variable CSS    ######### */
  :root {
    /*========== Colors ==========*/
    /* Change favorite color - Blue 210 - Purple 250 - Green 142 - Pink 340*/
    --hue-color: 210;

    /* HSL color mode */
    --first-color: hsl(var(--hue-color), 96%, 54%);
    --first-color-light: hsl(var(--hue-color), 96%, 69%);
    --first-color-alt: hsl(var(--hue-color), 96%, 37%);
    --first-color-lighter: hsl(var(--hue-color), 14%, 96%);
    --title-color: hsl(var(--hue-color), 12%, 15%);
    --text-color: hsl(var(--hue-color), 12%, 35%);
    --text-color-light: hsl(var(--hue-color), 12%, 65%);
    --white-color: #FFF;
    --body-color: hsl(var(--hue-color), 100%, 99%);
    --container-color: #FFF;

    /*========== Font and typography ==========*/
    --body-font: 'Lato', sans-serif;
    --pricing-font: 'Rubik', sans-serif;
    --biggest-font-size: 1.75rem;
    --normal-font-size: .938rem;
    --h2-font-size: 1.25rem;
    --small-font-size: .813rem;
    --smaller-font-size: .75rem;
    --tiny-font-size: .625rem;

    /*========== Margenes Bottom ==========*/
    --mb-0-25: .25rem;
    --mb-0-5: .5rem;
    --mb-1: 1rem;
    --mb-1-25: 1.25rem;
    --mb-1-5: 1.5rem;
    --mb-2: 2rem;
  }

  @media screen and (min-width: 968px) {
    :root {
      --biggest-font-size: 2.125rem;
      --h2-font-size: 1.5rem;
      --normal-font-size: 20px;
      --small-font-size: .875rem;
      --smaller-font-size: .813rem;
      --tiny-font-size: .688rem;
    }
  }

  /*==================== BASE ====================*/
  /* * {
    box-sizing: border-box;
    padding: 0;
    margin: 0;
  } */

  body {
    font-family: var(--body-font);
    font-size: var(--normal-font-size);
    background-color: var(--body-color);
    color: var(--text-color);
  }

  ul {
    list-style: none;
  }

  /* img {
    max-width: 100%;
    height: auto;
  } */

  /*==================== REUSABLE CSS CLASSES ====================*/
  .container {
    max-width: 1024px;
    margin-left: var(--mb-1-5);
    margin-right: var(--mb-1-5);
  }

  .grid {
    display: grid;
  }

  /*==================== CARD PRICING ====================*/
  .card {
    padding: 3rem 0;
  }

  .card__container {
    gap: 3rem 1.25rem;
  }

  .card__content {
    position: relative;
    background-color: var(--container-color);
    padding: 2rem 1.5rem 2.5rem;
    border-radius: 1.75rem;
    box-shadow: 0 12px 24px hsla(var(--hue-color), 61%, 16%, 0.1);
    transition: .4s;
  }

  .card__content:hover {
    box-shadow: 0 16px 24px hsla(var(--hue-color), 61%, 16%, 0.15);
  }

  .card__header-img {
    width: 30px;
    height: 30px;
  }

  .card__header-circle {
    width: 60px;
    height: 60px;
    background-color: var(--first-color-lighter);
    border-radius: 50%;
    margin-bottom: var(--mb-1);
    place-items: center;
  }

  .card__header-subtitle {
    display: block;
    font-size: var(--smaller-font-size);
    color: var(--text-color-light);
    text-transform: uppercase;
    margin-bottom: var(--mb-0-25);
  }

  .card__header-title {
    font-size: var(--biggest-font-size);
    color: var(--title-color);
    margin-bottom: var(--mb-1);
  }

  .card__pricing {
    position: absolute;
    background: linear-gradient(157deg, var(--first-color-light) -12%, var(--first-color) 109%);
    width: 95px;
    height: 88px;
    right: 1.5rem;
    border: none;
    outline: none;
    top: -1rem;
    padding-top: 1.25rem;
    text-align: center;
  }

  .card__pricing-number {
    font-family: var(--pricing-font);
  }

  .card__pricing-symbol {
    font-size: var(--smaller-font-size);
  }

  .card__pricing-number {
    font-size: var(--h2-font-size);
  }

  .card__pricing-month {
    display: block;
    font-size: var(--tiny-font-size);
  }

  .card__pricing-number,
  .card__pricing-month {
    color: var(--white-color);
  }

  .card__pricing::after,
  .card__pricing::before {
    content: '';
    position: absolute;
  }

  .card__pricing::after {
    width: 100%;
    height: 14px;
    background-color: var(--white-color);
    left: 0;
    bottom: 0;
    clip-path: polygon(0 100%, 50% 0, 100% 100%);
    border: 0;
  }

  .card__pricing::before {
    width: 14px;
    height: 16px;
    background-color: var(--first-color-alt);
    top: 0;
    left: -14px;
    border: none;
    clip-path: polygon(0 100%, 100% 0, 100% 100%);
  }

  .card__list {
    row-gap: .5rem;
    margin-bottom: 15px;
    height: 30vh;
    display: flex;
    flex-direction: column;
  }

  .card__list-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.2em;
  }

  .card__list-icon {
    font-size: 1.5rem;
    color: var(--first-color);
    margin-right: var(--mb-0-5);
  }

  .card__list-icon-2 {
    font-size: 1.5rem;
    color: #14CA27;
    margin-right: var(--mb-0-5);
  }

  .card__list-icon-3 {
    font-size: 1.5rem;
    color: #FFD700;
    margin-right: var(--mb-0-5);
  }

  .card__button {
    padding: 1.25rem;
    border: none;
    font-size: var(--normal-font-size);
    border-radius: .5rem;
    background: linear-gradient(157deg, var(--first-color-light) -12%, var(--first-color) 109%);
    color: var(--white-color);
    cursor: pointer;
    transition: .4s;
  }

  .card__button:hover {
    box-shadow: 0 12px 24px hsla(var(--hue-color), 97%, 54%, 0.2);
  }

  /*==================== MEDIA QUERIES ====================*/
  /* For small devices */
  @media screen and (max-width: 320px) {
    .container {
      margin-left: var(--mb-1);
      margin-right: var(--mb-1);
    }

    .card__content {
      padding: 2rem 1.25rem;
      border-radius: 1rem;
    }
  }

  /* For medium devices */
  @media screen and (min-width: 568px) and (max-width: 1024px) {
    .card__container {
      grid-template-columns: repeat(3, 1fr);
    }

    .card__content {
      grid-template-rows: repeat(2, max-content);
    }

    .card__button {
      align-self: flex-end;
    }
  }

  /* For large devices */
  @media screen and (min-width: 1025px) and (max-width: 4040px) {
    .container {
      margin-left: auto;
      margin-right: auto;
    }

    .card {
      height: 100vh;
      width: 100rem;
      align-items: center;
    }

    .card__container {
      grid-template-columns: repeat(3, 1fr);
    }

    .card__header-circle {
      margin-bottom: var(--mb-1-25);
    }

    .card__header-subtitle {
      font-size: var(--small-font-size);
    }
  }
</style>
@endpush




@section('content')

<section class="card container grid">
  <div class="card__container grid">
    @foreach ($subcriptionPlans as $plan)
    @php
    // Retrieve the price from the PlanPrice model based on the current plan ID
    $planPrice = \App\Models\PlanPrice::where('plan_id', $plan->id)->first();

    // Set image and header title based on plan type
    $image = '';
    $headerTitle = '';

    if ($plan->name === 'Basic') {
    $image = 'images/enterprise-coin.png';
    $headerTitle = 'Enterprise';
    } elseif ($plan->name === 'Pro') {
    $image = 'images/pro-coin.png';
    $headerTitle = 'Professional';
    } elseif ($plan->name === 'Premium') {
    $image = 'images/free-coin.png';
    $headerTitle = 'Basic';
    }
    @endphp

    <article class="card__content grid">

    <form action="{{ url('pricing/' . $plan->id) }}" method="POST" class="subscription-form">


        @csrf
        <div class="card__pricing">
          <div class="card__pricing-number">
            <span class="card__pricing-symbol">GHC</span>{{ $planPrice ? $planPrice->price : 'N/A' }}
          </div>
          <span class="card__pricing-month">/month</span>
        </div>

        <header class="card__header">
          <div class="card__header-circle grid">
            <img src="{{ asset($image) }}" alt="" class="card__header-img" />
          </div>
          <span class="card__header-subtitle">{{ $plan->name }}</span>
          <h1 class="card__header-title">{{ $headerTitle }}</h1>
        </header>

        <ul class="card__list grid">
          @foreach($plan->features as $feature)
          <li class="card__list-item">
            {{-- Use different icon classes based on the plan type --}}
            @if ($plan->name === 'Silver')
            <i class="uis uis-check-circle card__list-icon"></i>
            @elseif ($plan->name === 'Diamond')
            <i class="uis uis-check-circle card__list-icon-2"></i>
            @elseif ($plan->name === 'Gold')
            <i class="uis uis-check-circle card__list-icon-3"></i>
            @endif
            {{-- Remove hyphens from feature name and capitalize first letter of each word --}}
            <p class="card__list-description">{{ ucwords(str_replace('-', ' ', $feature->name)) }}</p>
          </li>
          @endforeach
        </ul>

        
        <button type="submit" class="card__button subscribe-btn">Choose this plan</button>
      </form>
    </article>
    @endforeach
  </div>
</section>

@stop





@push('scripts')
<!-- <script>
  // JavaScript logic to handle subscription action
  const subscribeButtons = document.querySelectorAll('.subscribe-btn');
  subscribeButtons.forEach(button => {
    button.addEventListener('click', function() {

      const planId = this.getAttribute('data-plan-id');
      console.log(planId);
      // Perform subscription action using AJAX
      const data = {
        planId: planId
      };
      // Example: Make an AJAX POST request to the backend endpoint
      fetch('/pricing/' + planId, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for Laravel
          },
          body: JSON.stringify(data)
        })
        .then(response => {
          console.log(response.status, response.statusText);
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          window.location.href = data.url;
          // console.log('Subscription successful:', data);
          // // Display success message using Toastr
          // toastr.success('Subscription successful!');
          // Perform further actions after successful subscription if needed
        })
        .catch(error => {

          // Display error message using Toastr
          toastr.error('There was a problem with the subscription.', error);
        });
    });
  });
</script> -->



@endpush