    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <!-- Navbar content -->
        <a class="navbar-brand" href="#">綠色銀行</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="main.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">帳戶資料</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          操作
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="withdraw.php">提款</a>
          <a class="dropdown-item" href="deposit.php">存款</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="detail.php">查看明細</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
    <span id="navBarUserName" class="navbar-text" style="margin-right: 10px;color:white">
            hello,
          </span>
    <form class="form-inline my-2 my-lg-0">
    <div class="col" style="text-align:right">
      <button type="button" class="btn btn-light" onclick="logout();">登出</button>
    </div>
    </form>
  </div>
    </nav>

