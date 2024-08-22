@if(flash()->message)
<div class="alert {{ flash()->class ?? "alert-info" }} alert-dismissible fade show" role="alert">
    <strong>Informasi Penting! </strong>{{ flash()->message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif