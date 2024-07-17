 
 <style>
    .thumb-holder{
        height: 29vh;
        width: 100%;
    }
    img.img-fluid.facility-thumbnail {
        width: 100%;
        height: 100%;
        object-fit:scale-down;
        object-position:center center;
        transition: transform .3s ease-in;
    }
    .book_facility:hover .facility-thumbnail{
        transform:scale(1.2)
    }
 </style>
 <!-- Header-->
 <header class="bg-dark py-5" id="main-header">
    <div class="container h-100 d-flex align-items-center justify-content-center w-100">
        <div class="text-center text-white w-100">
            <h1 class="display-4 fw-bolder">Available Facilities</h1>
            <!-- <p class="lead fw-normal text-white-50 mb-0">We will take care of your vehicle</p> -->
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                <div class="input-group mb-3">
                    <input type="search" id="search" class="form-control" placeholder="Search Here" aria-label="Search Here" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text bg-primary" id="basic-addon2"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                </div>
                <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-xl-2" id="facility_list">
                    <?php 
                    $facilities = $conn->query("SELECT f.*, c.name as category FROM `facility_list` f inner join category_list c on f.category_id = c.id where f.delete_flag = 0  order by f.`facility_code`");
                    while($row= $facilities->fetch_assoc()):
                    ?>
                    <a class="col item text-decoration-none text-dark book_facility" href="./?p=view_facility&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>" >
                        <div class="callout callout-primary border-primary rounded-0">
                            <dl>
                                <dt class="h3">
                                    <center>
                                        <div class="position-relative overflow-hidden thumb-holder">
                                            <img src="<?= validate_image($row['image_path']) ?>" alt="" class="img-fluid facility-thumbnail">
                                        </div>
                                    </center>
                                </dt>
                                <dd class=" lh-1">
                                    <div class="h4"><?php echo $row['category'] ?></div>
                                    <div><?php echo $row['name'] ?></div>
                                    <div class="clear-fix py-2"></div>
                                    <p class="truncate-3 m-0"><?= strip_tags(html_entity_decode($row['description'])) ?></p>
                                </dd>
                            </dl>
                        </div>
                    </a>
                    <?php endwhile; ?>
                </div>
                <div id="noResult" style="display:none" class="text-center"><b>No Result</b></div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#search').on('input',function(){
            var _search = $(this).val().toLowerCase().trim()
            $('#facility_list .item').each(function(){
                var _text = $(this).text().toLowerCase().trim()
                    _text = _text.replace(/\s+/g,' ')
                    console.log(_text)
                if((_text).includes(_search) == true){
                    $(this).toggle(true)
                }else{
                    $(this).toggle(false)
                }
            })
            if( $('#facility_list .item:visible').length > 0){
                $('#noResult').hide('slow')
            }else{
                $('#noResult').show('slow')
            }
        })
        $('#facility_list .item').hover(function(){
            $(this).find('.callout').addClass('shadow')
        })
      

    })
    $(document).scroll(function() { 
        $('#topNavBar').removeClass('bg-transparent navbar-light navbar-dark bg-gradient-light text-light')
        if($(window).scrollTop() === 0) {
           $('#topNavBar').addClass('navbar-dark bg-transparent text-light')
        }else{
           $('#topNavBar').addClass('navbar-light bg-gradient-light ')
        }
    });
    $(function(){
        $(document).trigger('scroll')
    })
</script>