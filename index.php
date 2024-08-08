<head>

<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css"
  rel="stylesheet"
/>
<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"
></script>
</head>

<style>

.divider:after,
.divider:before {
content: "";
flex: 1;
height: 1px;
background: #c9e5e1;
}

</style>

<body>


<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="./logo.png"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

      <br>


      <h2 class="text-center">Login</h2>

      <br>


        <form action="authenticate.php" method="post">
          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input name="username" id="form1Example13" class="form-control form-control-lg" />
            <label class="form-label" for="form1Example13">Usuário</label>
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input name="password" type="password" id="form1Example23" class="form-control form-control-lg" />
            <label class="form-label" for="form1Example23">Senha</label>
          </div>

          <input type="submit" value="Entrar" class="btn btn-dark">
        </form>



        <!-- MDB -->
<script
type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"
></script>
          
</body>
