@extends('master')

@section('main')
    <section class="cd-faq">
        <ul class="cd-faq-categories">
            <li><a class="selected" href="#faq-group-1">First</a></li>
        </ul> <!-- cd-faq-categories -->

        <div class="cd-faq-items">
            <ul id="faq-group-1" class="cd-faq-group">
                <li class="cd-faq-title"><h2>First</h2></li>
                <li>
                    <a class="cd-faq-trigger" href="#0">Perferendis beatae labore nihil aliquid delectus saepe?</a>
                    <div class="cd-faq-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae quidem blanditiis delectus corporis, possimus officia sint sequi ex tenetur id impedit est pariatur iure animi non a ratione reiciendis nihil sed consequatur atque repellendus fugit perspiciatis rerum et. Dolorum consequuntur fugit deleniti, soluta fuga nobis. Ducimus blanditiis velit sit iste delectus obcaecati debitis omnis, assumenda accusamus cumque perferendis eos aut quidem! Aut, totam rerum, cupiditate quae aperiam voluptas rem inventore quas, ex maxime culpa nam soluta labore at amet nihil laborum? Explicabo numquam, sit fugit, voluptatem autem atque quis quam voluptate fugiat earum rem hic, reprehenderit quaerat tempore at. Aperiam.</p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">How do I sign up?</a>
                    <div class="cd-faq-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi cupiditate et laudantium esse adipisci consequatur modi possimus accusantium vero atque excepturi nobis in doloremque repudiandae soluta non minus dolore voluptatem enim reiciendis officia voluptates, fuga ullam? Voluptas reiciendis cumque molestiae unde numquam similique quas doloremque non, perferendis doloribus necessitatibus itaque dolorem quam officia atque perspiciatis dolore laudantium dolor voluptatem eligendi? Aliquam nulla unde voluptatum molestiae, eos fugit ullam, consequuntur, saepe voluptas quaerat deleniti. Repellendus magni sint temporibus, accusantium rem commodi?</p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Can I remove a ad?</a>
                    <div class="cd-faq-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis provident officiis, reprehenderit numquam. Praesentium veritatis eos tenetur magni debitis inventore fugit, magnam, reiciendis, saepe obcaecati ex vero quaerat distinctio velit.</p>
                    </div> <!-- cd-faq-content -->
                </li>

            </ul> <!-- cd-faq-group -->

        </div> <!-- cd-faq-items -->
        <a href="#0" class="cd-close-panel">Close</a>
    </section> <!-- cd-faq -->
@endsection