
  <div id="modal" class="modal">
    <div class="modal-content">
      <button class="modal-close" id="close">&Cross;</button>
      <h2 class="modal-h2"><?=strtoupper($_GET['error']);?></h2>
      <img class="modal-img" src="img/ex.svg">
    </div>
  </div>

  <style>
  .modal {
    opacity: 1;
    visibility: visible;
  }
  .modal .modal-content {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
  }
  </style>

  <script>
    $("#close").on("click", ()=>{
      $("#modal").remove()
    })
  </script>


