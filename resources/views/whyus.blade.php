@extends('website.app')

@section('styles')
<link href="{{asset('asset/front/css/slick.css')}}" rel="stylesheet">
<link href="{{asset('asset/front/css/slick-theme.css')}}"/>
<style type="text/css">


.book_now_wrap  .btn.btn-default.sid_tg {
    text-transform: uppercase;
    font-family: 'open_sansbold';
    font-size: 16px;
    color: #333333;
    background-color: #2bb673;
    border-color: #2bb673;
    border-radius: 0;
    width: 100%;
    text-align: left;
    height: 40px;
    line-height: 28px;
    position: relative;
}

.book_now_wrap figure {
   float: right;
}
.slick-prev{
   z-index: 0 !important;
}
.slick-next{
   z-index: 0 !important;
}
</style>
@endsection

@section('content')
<div class="get_there">
   <div class="banner">
    <div class="container">
      <h1 style="color: #32B0E9">impressum</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos neque doloribus vitae, voluptas perferendis perspiciatis consequatur minus blanditiis quasi labore deserunt pariatur velit in natus asperiores, aliquid architecto ad repudiandae odio non mollitia quo maxime accusamus ducimus amet. Suscipit corporis mollitia sint sit excepturi porro nemo ipsa explicabo ducimus necessitatibus reprehenderit beatae architecto fuga quisquam ipsam vel exercitationem quis accusantium optio iure ratione consequatur, dolores, illum. Facere blanditiis ex voluptatum, architecto veritatis fugiat ducimus incidunt praesentium iusto! Suscipit voluptates facilis, quis ducimus ab fuga vel molestias natus odit voluptate cum. Voluptatem modi, architecto molestias, vero laborum similique repellendus. Cupiditate reiciendis, quas distinctio ad blanditiis, facilis debitis quaerat nam eaque, in sed facere, eum quae odio minus tenetur excepturi fugiat accusantium! Expedita animi at ducimus. At iste quod alias distinctio odio qui inventore neque, quisquam nam amet, magnam maxime cum, non culpa assumenda cupiditate, error ab. Distinctio facere libero nam laboriosam praesentium eius omnis, non in et consequuntur sed, aut perspiciatis ullam, deserunt sit totam aperiam voluptates temporibus nulla, necessitatibus quod amet nesciunt? Incidunt quo quod, vel laudantium excepturi, sint voluptate consequatur atque, a nisi ipsa earum sequi quis dolores laboriosam, sed voluptatem eligendi? Culpa eaque assumenda, quod sit quaerat nam! </p>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic tempore vero itaque dicta alias odio suscipit ipsam in deleniti a voluptates unde iste beatae doloremque sed deserunt, accusantium voluptatibus quasi harum libero. Rerum eum, minima beatae temporibus. Adipisci illo rerum et libero numquam magni quisquam est illum beatae vitae quam suscipit itaque nesciunt, obcaecati ab cumque nihil molestiae ullam animi quibusdam quis ipsum tenetur! Nihil repudiandae, laborum amet praesentium iusto, molestiae maiores fugiat ut est culpa inventore accusamus nisi repellendus laudantium totam. Consequatur saepe magni adipisci labore aperiam nihil voluptatibus iusto velit in, suscipit nisi itaque, quisquam, unde perspiciatis porro. Alias quidem eligendi temporibus ab voluptates praesentium fuga, omnis, ut, qui impedit architecto nesciunt cumque. Voluptatibus deleniti maxime totam beatae.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic tempore vero itaque dicta alias odio suscipit ipsam in deleniti a voluptates unde iste beatae doloremque sed deserunt, accusantium voluptatibus quasi harum libero. Rerum eum, minima beatae temporibus. Adipisci illo rerum et libero numquam magni quisquam est illum beatae vitae quam suscipit itaque nesciunt, obcaecati ab cumque nihil molestiae ullam animi quibusdam quis ipsum tenetur! Nihil repudiandae, laborum amet praesentium iusto, molestiae maiores fugiat ut est culpa inventore accusamus nisi repellendus laudantium totam. Consequatur saepe magni adipisci labore aperiam nihil voluptatibus iusto velit in, suscipit nisi itaque, quisquam, unde perspiciatis porro. Alias quidem eligendi temporibus ab voluptates praesentium fuga, omnis, ut, qui impedit architecto nesciunt cumque. Voluptatibus deleniti maxime totam beatae.</p>
    </div>
   </div>
</div>




@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('asset/front/js/slick.min.js')}}"></script>
@endsection