<form action="/actions/submit-contact" method="post">
  <?=csrf_field()?>
  <input type="hidden" name="source_page" value="<?=e(current_page())?>">
  <div class="form-grid">
    <input name="name" required placeholder="Name">
    <input name="phone" required placeholder="Phone / WhatsApp">
    <input name="email" type="email" placeholder="Email">
    <input name="city" placeholder="Project location">
    <select name="product_interest">
      <option value="">Product interest</option>
      <option>Doors</option><option>Windows</option><option>Skylights</option><option>Doors + Windows</option><option>Commercial project</option>
    </select>
    <input name="preferred_contact" placeholder="Preferred contact time">
    <textarea class="full" name="message" placeholder="Tell us about your project, model, quantity or dimensions"></textarea>
    <button class="btn btn-accent full" type="submit">Send Inquiry</button>
  </div>
</form>
