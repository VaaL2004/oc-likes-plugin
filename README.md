# oc-likes-plugin

#Rate a specific object
To configure the plugin for a specific record in the database, just connect the component and specify the model namespace and record ID.
For example, the first user of the plugin RainLab.User
```
[LikeButton]
likeable_type = "October\Rain\Auth\Models\User"
likeable_id = 1
```

#Rate a specific object from url
Let's say you have a page "/users/:id".
To configure the plugin in such a way as to rate the user this page belongs to, you need to set the likeable_id so that it corresponds to the id variable
```
[LikeButton]
likeable_type = "October\Rain\Auth\Models\User"
likeable_id = "{{ :id }}"
```

#Likes in list
Alternatively, you can pass the object ID directly to the component. This is useful, for example, when listing objects.
Let's say you are listing posts.
In this case, just connect the component, specify the model, and pass the ID when listing.
```
[LikeButton]
likeable_type = "October\Rain\Auth\Models\User"
likeable_id = "1"
```
```
{% for user in users %}
 {% component 'LikeButton' likeable_id=user.id %}
{% endfor %}
```
