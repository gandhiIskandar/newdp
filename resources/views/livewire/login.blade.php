<div class="auth-main v1">
    <div class="bg-overlay bg-white"></div>
    <div class="auth-wrapper">
      <div class="auth-form">
        <a href="#" class="d-block mt-5"><img src="{{ asset('assets/images/logo-white.svg') }}" alt="img" /></a>
        <div class="card mb-5 mt-3">
          <div class="card-header bg-dark">
            <h4 class="text-center text-white f-w-500 mb-0">Login with your email</h4>
          </div>
          <div class="card-body">
            <x-partials.flash-message />
            <form  wire:submit='login'> 
            <div class="mb-3">
              <input type="email" wire:model='form.email' class="form-control" id="floatingInput" placeholder="Email Address" required/>
            </div>
            <div class="mb-3">
              <input type="password" wire:model='form.password' class="form-control" id="floatingInput1" placeholder="Password" required/>
            </div>
            <div class="d-flex mt-1 justify-content-between align-items-center">
              <div class="form-check">
                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="" />
                <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
              </div>
            </div>
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </div>
        </form>
        
        </div>
      </div>
    </div>
  </div> 


 