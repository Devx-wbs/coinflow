  <body>

   @include('home-fronted.include.header');

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Pricing</h1>
      <p class="lead">Quickly build an effective pricing table for your potential customers with this Bootstrap example. It's built with default Bootstrap components and utilities with little customization.</p>
    </div>

    <div class="container">
        <div class="card-deck mb-3 text-center">
            @foreach($plans as $plan)
                <div class="card mb-4 box-shadow">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{ $plan->name }}</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">
                            ${{ number_format($plan->price, 2) }}
                            <small class="text-muted">/ {{ $plan->duration }} {{ $plan->duration_type }}</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>{{ $plan->description }}</li>
                            <li>Max activations: {{ $plan->max_activations }}</li>
                            <li>License type: {{ $plan->license_type }}</li>
                            <li>Trial days: {{ $plan->trial_days }}</li>
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-outline-primary">
                            Subscribe
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

      </div>

     @include('home-fronted.include.footer');
    </div>


  </body>