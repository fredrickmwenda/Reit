@extends('Backend::layouts.master')

@section('title', 'Subscription Plans')

@push('styles')
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/solid.css">
<style>
  



  ul {
    list-style: none;
  }

  /* img {
    max-width: 100%;
    height: auto;
  } */

  /*==================== REUSABLE CSS CLASSES ====================*/
  /* .container {
    max-width: 1024px;
    margin-left: var(--mb-1-5);
    margin-right: var(--mb-1-5);
  }

  .grid {
    display: grid;
  } */

  /*==================== CARD PRICING ====================*/
  .card {
    padding: 3rem 0;
  }

  .card__container {
    gap: 3rem 1.25rem;
  }

  .card__content {
    position: relative;
    background-color: #FFF;
    padding: 2rem 1.5rem 2.5rem;
    border-radius: 1.75rem;
    box-shadow: 0 12px 24px hsla(210, 61%, 16%, 0.1);
    transition: .4s;
  }

  .card__content:hover {
    box-shadow: 0 16px 24px hsla(210, 61%, 16%, 0.15);
  }

  .card__header-img {
    width: 30px;
    height: 30px;
  }

  .card__header-circle {
    width: 60px;
    height: 60px;
    background-color: hsl(210, 14%, 96%);
    border-radius: 50%;
    margin-bottom: 1rem;
    place-items: center;
  }

  .card__header-subtitle {
    display: block;
    font-size: .75rem;
    color: hsl(210, 12%, 65%);
    text-transform: uppercase;
    margin-bottom: .25rem;
  }

  .card__header-title {
    font-size: .75rem;
    color: vhsl(210, 12%, 15%);
    margin-bottom: 1rem;
  }

  .card__pricing {
    position: absolute;
    background: linear-gradient(157deg, hsl(210, 96%, 69%) -12%, hsl(210, 96%, 54%) 109%);
    width: 60px;
    height: 88px;
    right: 1.5rem;
    border: none;
    outline: none;
    top: -1rem;
    padding-top: 1.25rem;
    text-align: center;
  }

  /* .card__pricing-number {
    font-family: var(--pricing-font);
  } */

  .card__pricing-symbol {
    font-size: .75rem;
  }

  .card__pricing-number {
    font-size: 1.25rem;
  }

  .card__pricing-month {
    display: block;
    font-size: .625rem;
  }

  .card__pricing-number,
  .card__pricing-month {
    color: #FFF;
  }

  .card__pricing::after,
  .card__pricing::before {
    content: '';
    position: absolute;
  }

  .card__pricing::after {
    width: 100%;
    height: 14px;
    background-color: #FFF;
    left: 0;
    bottom: 0;
    clip-path: polygon(0 100%, 50% 0, 100% 100%);
    border: 0;
  }

  .card__pricing::before {
    width: 14px;
    height: 16px;
    background-color: hsl(210, 96%, 37%);
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
    color: hsl(210, 96%, 54%);
    margin-right: .5rem;
  }

  .card__list-icon-2 {
    font-size: 1.5rem;
    color: #14CA27;
    margin-right:.5rem;
  }

  .card__list-icon-3 {
    font-size: 1.5rem;
    color: #FFD700;
    margin-right: .5rem;
  }

  .card__button {
    padding: 1.25rem;
    border: none;
    font-size: .938rem;
    border-radius: .5rem;
    background: linear-gradient(157deg, hsl(210, 96%, 69%) -12%, hsl(210, 96%, 54%) 109%);
    color: #FFF;
    cursor: pointer;
    transition: .4s;
  }

  .card__button:hover {
    box-shadow: 0 12px 24px hsla(210, 97%, 54%, 0.2);
  }

  /*==================== MEDIA QUERIES ====================*/
  /* For small devices */
  @media screen and (max-width: 320px) {
    .container {
      margin-left: 1rem;
      margin-right: 1rem;
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
      
      align-items: center;
    }

    .card__container {
      grid-template-columns: repeat(3, 1fr);
    }

    .card__header-circle {
      margin-bottom: 1.25rem;
    }

    .card__header-subtitle {
      font-size: .813rem;
    }
  }
</style>
@endpush

@section('content')



<div class="layout-top-spacing">
    <div class="statbox widget box box-shadow">

        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4></h4>

                    </div>
                </div>
            </div>
        </div>
<div class="card container grid">
        <div class="card__container grid">
            @foreach ($subcriptionPlans as $plan)
            @php
        


            // Set image and header title based on plan type
            $image = '';
            $headerTitle = '';

            if ($plan->name === 'Gold') {
            $image = 'images/enterprise-coin.png';
            $headerTitle = 'Enterprise';
            } elseif ($plan->name === 'Diamond') {
            $image = 'images/pro-coin.png';
            $headerTitle = 'Professional';
            } elseif ($plan->name === 'Silver') {
            $image = 'images/free-coin.png';
            $headerTitle = 'Basic';
            }
            @endphp

            <article class="card__content grid">

                <form action="{{ url('pricing/' . $plan->id) }}" method="POST" class="subscription-form">


                    @csrf
                    <div class="card__pricing">
                        <div class="card__pricing-number">
                            <span class="card__pricing-symbol">GHS</span>{{ $plan->prices->price }}
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


                    <button type="submit" class="card__button subscribe-btn">Choose/Revert to this plan</button>
                </form>
            </article>
            @endforeach
        </div>
        </div>

    </div>
</div>
@stop