<div class="row">
    <div class="col-12 col-lg-7">
        <% if $Results %>
            <% loop $Results %>
                <% include S2Hub\MembershipDirectory\Includes\MembershipListingResultItem %>
            <% end_loop %>
        <% else %>
            <p><%t S2MemberDirectory.NoResults "Sorry, there are no results for your seach." %></p>
        <% end_if %>
    </div>
    <div class="col-12 col-lg-5">
        Map
    </div>
</div>
