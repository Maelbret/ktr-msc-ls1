<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
    <div class="container">
        <a class="navbar-brand" href="index.php">My Business Cards</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                <?php if (isConnected()) : ?><li class="nav-item">
                        <a class="nav-link" href="index.php">My cards</a>
                    </li><?php endif; ?>
                <?php if (isConnected()) : ?><li class="nav-item">
                        <a class="nav-link" href="account.php">My account</a>
                    </li><?php endif; ?>
            </ul>
        </div>
        <?php if (isConnected()) : ?><a href="signin.php?signout" class="btn btn-link">Logout</a><?php endif; ?>
    </div>
</nav>