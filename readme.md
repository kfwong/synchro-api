# Synchro API

Synchro is a experimental project for Orbital 2016 @ NUS SoC.

This repository contains the API logic to perform Creation/Retrieval, as well as further analyzation of user profiles.

Synchro API make use of [IVLE LAPI](https://wiki.nus.edu.sg/display/ivlelapi/Summary), only users possessed valid NUS account can access this API.

## Synchro API Endpoints Documentation

**All endpoints are required to set the IVLE Token in the HTTP Authorization Header**

```yaml
HTTP/1.1
Authorization: {Token Value}
```

 Status | Endpoint | HTTP Method | Description |
--------|----------|-------------|-------------|
 O | [api/v1/groups](#get-apiv1groups) | GET | Retrieve list of available Groups
 O | [api/v1/groups](#post-apiv1groups) | POST | Create a new Group
 O | [api/v1/groups/{group_id}](#get-apiv1groupsgroup_id) | GET | Retrieve a Group by id
 O | [api/v1/groups/{group_id}](#put-apiv1groupsgroup_id) | PUT | Update a Group by id
 O | [api/v1/groups/{group_id}](#delete-apiv1groupsgroup_id) | DELETE | Delete a Group by id (soft delete)
 O | [api/v1/groups/{group_id}/posts](#get-apiv1groupsgroup_idposts) | GET | Retrieve all posts belongs to a specific Group
 O | [api/v1/groups/{group_id}/users](#get-apiv1groupsgroup_idusers) | GET | Retrieve all users belongs to a specific Group
 X | [api/v1/groups/{group_id}/tags](#get-apiv1groupsgroup_idtags) | GET | Retrieve all tags belongs to a specific Group
 O | [api/v1/groups/search?{name&#124;tags}](#get-apiv1groupssearchnametags) | GET | Search group by name or tags
 O | [api/v1/users](#get-apiv1users) | GET | Retrieve list of Users
 O | [api/v1/users/{user_id}](#get-apiv1usersuser_id) | GET | Retrieve a User profile
 O | [api/v1/users/{user_id}/groups](#get-apiv1usersuser_idgroups) | GET | Retrieve list of Groups a particular User belongs to
 O | [api/v1/users/{user_id}/groups/recommends](#get-apiv1usersuser_idgroupsrecommends) | GET | Retrieve list of suggested group to that particular user with {user_id}, match by common module within each group members, excluding the one he/she already joined.
 O | [api/v1/users/{user_id}/modulesTaken](#get-apiv1usersuser_idmodulestaken) | GET | Retrieve a User's modules taken
 O | [api/v1/users/{user_id}/posts](#get-apiv1usersuser_idposts) | GET | Retrieve a posts belongs to a user
 O | [api/v1/posts](#post-apiv1posts) | POST | Create a new Post
 O | [api/v1/posts/{post_id}](#get-apiv1postspost_id) | GET | Retrieve a post by post_id
 O | [api/v1/me](#get-apiv1me) | GET | Retrieve current authenticated User
 O | [api/v1/me](#put-apiv1me) | PUT | Update current authenticated User
 O | [api/v1/me/groups](#get-apiv1megroups) | GET | Retrieve list of Groups that current authenticated User belongs to
 O | [api/v1/me/groups/{group_id}/join](#post-apiv1megroupsgroup_idjoin) | POST | Current User join an existing group.
 O | [api/v1/me/groups/{group_id}/leave](#post-apiv1megroupsgroup_idleave) | POST | Current User leave an existing group.
 O | [api/v1/me/posts](#get-apiv1meposts) | GET | Retrieve posts belongs to the current authenticated User
 O | [api/v1/me/modulesTaken](#get-apiv1memodulestaken) | GET | Retrieve list of Modules that current authenticated User has taken
 O | [api/v1/me/resync](#get-apiv1meresync) | GET | Resynchronize & cache current user info from IVLE

---

### GET api/v1/groups
Retrieve list of available Groups

**Request Parameters:**
None

**Response:**

HTTP 200 OK
```json
 [
   {
     "id": 2,
     "name": "qui",
     "type": "",
     "description": "",
     "date_happening": "0000-00-00 00:00:00",
     "venue": "",
     "created_at": "2016-07-12 15:37:44",
     "updated_at": "2016-07-12 15:37:44",
     "deleted_at": null,
     "tags": [
       "id",
       "voluptatem",
       "dignissimos"
     ]
   },
   {
     "id": 3,
     "name": "hic",
     "type": "",
     "description": "",
     "date_happening": "0000-00-00 00:00:00",
     "venue": "",
     "created_at": "2016-07-12 15:37:44",
     "updated_at": "2016-07-12 15:37:44",
     "deleted_at": null,
     "tags": [
       "voluptas"
     ]
   },
   {
     "id": 4,
     "name": "voluptas",
     "type": "",
     "description": "",
     "date_happening": "0000-00-00 00:00:00",
     "venue": "",
     "created_at": "2016-07-12 15:37:44",
     "updated_at": "2016-07-12 15:37:44",
     "deleted_at": null,
     "tags": [
       "esse"
     ]
   }]
 ```

 ---

### POST api/v1/groups
Create a new Group

**Request Parameters:**

Body:
 ```json
 {
 "name": "My new study group",
 "type": "study",
 "description": "lorem ipsum",
 "date_happening": "2016-06-10 15:04:47",
 "venue": "soc",
 "tags": "study cs1010 exam"
 }
 ```

 **Response:**

 HTTP 201 CREATED
 ```json
 {
"message": "Group created.",
"id": 1
 }
```

---

### GET api/v1/groups/{group_id}
Retrieve a Group by id

**Request Parameters:**

URL:

{group_id}: ID of the group.

**Response:**

HTTP 200 OK
```json
{
  "id": 2,
  "name": "qui",
  "type": "",
  "description": "",
  "date_happening": "0000-00-00 00:00:00",
  "venue": "",
  "created_at": "2016-07-12 15:37:44",
  "updated_at": "2016-07-12 15:37:44",
  "deleted_at": null,
  "tags": [
    "id",
    "voluptatem",
    "dignissimos"
  ]
}
```
---

### PUT api/v1/groups/{group_id}
Update a Group by id

**Request Parameters:**

URL:

{group_id}: ID of the group.

Body:

```json
{
"name" : "updated1",
"type": "updated2",
"description": "updated3",
"date_happening": "1991-07-06 13:23:45",
"venue": "soc",
"tags": "tag1 tag2 tag3"
}
```

**Response:**

HTTP 200 OK

```json
{
  "message": "Group updated."
}
```

---

### DELETE api/v1/groups/{group_id}
Delete a Group by id (soft delete)

**Request Parameters:**

URL:

{group_id}: ID of the group.

**Response:**

HTTP 200 OK
```json
{
  "message": "Group 2 has been deleted."
}
```

---

### GET api/v1/groups/{group_id}/posts
Retrieve all posts belongs to a specific Group

**Request Parameters:**

URL:

{group_id}: ID of the group.

**Response:**

HTTP 200 OK
```json
[
  {
    "id": 11,
    "content": "Ut quos aut tempore rerum ullam quia. Nam rerum ad voluptatem rerum in temporibus. Ipsam alias eveniet et consequuntur accusamus.",
    "user_id": 2,
    "group_id": 2,
    "created_at": "2016-07-19 11:11:05",
    "updated_at": "2016-07-19 11:11:05"
  },
  {
    "id": 19,
    "content": "Nisi laboriosam doloremque dolor sed qui mollitia. Illum eum in qui deserunt. Ut inventore aperiam in natus cupiditate sed ut. Eos totam suscipit atque dolorem.",
    "user_id": 15,
    "group_id": 2,
    "created_at": "2016-07-19 11:11:05",
    "updated_at": "2016-07-19 11:11:05"
  },
  {
    "id": 35,
    "content": "Est qui ex quos nostrum unde. Vel natus eum itaque ipsam iusto incidunt. Molestias fugit laudantium necessitatibus ut. Velit voluptas eum reprehenderit et neque.",
    "user_id": 8,
    "group_id": 2,
    "created_at": "2016-07-19 11:11:06",
    "updated_at": "2016-07-19 11:11:06"
  },
  {
    "id": 50,
    "content": "Tempora non qui voluptatem necessitatibus facilis aspernatur officia. Expedita dolorem corrupti id consequatur. Non voluptatem omnis qui eum.",
    "user_id": 7,
    "group_id": 2,
    "created_at": "2016-07-19 11:11:07",
    "updated_at": "2016-07-19 11:11:07"
  },
  {
    "id": 93,
    "content": "Necessitatibus nobis atque iste aliquid eaque. Vitae ut sint unde cumque dolorem saepe. Est dolor deserunt dolorem non. Velit id doloribus eius dolores qui aut nulla.",
    "user_id": 11,
    "group_id": 2,
    "created_at": "2016-07-19 11:11:10",
    "updated_at": "2016-07-19 11:11:10"
  },
  {
    "id": 97,
    "content": "Non quae enim sit qui. Sed sit est facere nihil possimus. Quas atque eaque perferendis autem. Maiores voluptates nesciunt praesentium eaque adipisci beatae molestias eaque.",
    "user_id": 15,
    "group_id": 2,
    "created_at": "2016-07-19 11:11:10",
    "updated_at": "2016-07-19 11:11:10"
  },
  {
    "id": 101,
    "content": "lorem ipsum dollar sit amet.",
    "user_id": 16,
    "group_id": 2,
    "created_at": "2016-07-20 20:11:36",
    "updated_at": "2016-07-20 20:11:36"
  },
  {
    "id": 102,
    "content": "lorem ipsum dollar sit amet.",
    "user_id": 16,
    "group_id": 2,
    "created_at": "2016-07-20 20:11:37",
    "updated_at": "2016-07-20 20:11:37"
  },
  {
    "id": 103,
    "content": "lorem ipsum dollar sit amet.",
    "user_id": 16,
    "group_id": 2,
    "created_at": "2016-07-20 20:12:04",
    "updated_at": "2016-07-20 20:12:04"
  },
  {
    "id": 104,
    "content": "lorem ipsum dollar sit amet.",
    "user_id": 16,
    "group_id": 2,
    "created_at": "2016-07-20 20:12:04",
    "updated_at": "2016-07-20 20:12:04"
  }
]
```

---

### GET api/v1/groups/{group_id}/users
Retrieve all users belongs to a specific Group

**Request Parameters:**

URL:

{group_id}: ID of the group.

**Response:**

HTTP 200 OK
```json
[
  {
    "id": 8,
    "ivle_id": "n8518806",
    "name": "Elissa Sipes V",
    "email": "sid.kuphal@dare.com",
    "gender": "Male",
    "faculty": "Sed nihil non provident.",
    "first_major": "Dolores cumque et fugiat.",
    "second_major": "Voluptatum vel quasi fuga cumque.",
    "matriculation_year": "1994",
    "last_seen_at": "1977-04-02 04:50:56",
    "last_sync_at": "2003-11-24 16:51:15",
    "created_at": "2016-07-12 15:37:43",
    "updated_at": "2016-07-12 15:37:43",
    "pivot": {
      "group_id": 2,
      "user_id": 8,
      "is_admin": 0
    }
  },
  {
    "id": 10,
    "ivle_id": "v6829262",
    "name": "Otilia Nienow",
    "email": "kaya.leuschke@gmail.com",
    "gender": "Female",
    "faculty": "Quasi omnis voluptatem quia.",
    "first_major": "Commodi eos dicta dolorum.",
    "second_major": "Eos quod adipisci tenetur.",
    "matriculation_year": "2001",
    "last_seen_at": "1986-10-07 03:52:15",
    "last_sync_at": "1994-06-10 20:52:48",
    "created_at": "2016-07-12 15:37:43",
    "updated_at": "2016-07-12 15:37:43",
    "pivot": {
      "group_id": 2,
      "user_id": 10,
      "is_admin": 1
    }
  },
  {
    "id": 15,
    "ivle_id": "k4588836",
    "name": "Theresa Schneider",
    "email": "wmcdermott@yahoo.com",
    "gender": "Male",
    "faculty": "Praesentium soluta molestiae officiis.",
    "first_major": "Repellat sint.",
    "second_major": "Nulla consequatur et.",
    "matriculation_year": "2011",
    "last_seen_at": "1998-01-09 04:31:01",
    "last_sync_at": "1989-04-03 08:44:49",
    "created_at": "2016-07-12 15:37:44",
    "updated_at": "2016-07-12 15:37:44",
    "pivot": {
      "group_id": 2,
      "user_id": 15,
      "is_admin": 1
    }
  }
]
```

---

### GET	api/v1/groups/{group_id}/tags
Retrieve all tags belongs to a specific Group

//TODO: to be updated

---

### GET api/v1/groups/search?{name|tags}
Search group by name or tags. Note that you can choose either, or both keys in the request parameters. All combinations (keys and values) uses OR operation.

eg:
```HTTP
api/v1/groups/search?name=tempora et qui
api/v1/groups/search?tags=esse magni
api/v1/groups/search?name=tempora et qui&tags=esse magni
```

**Request Parameters:**

URL:

{name}: name of the group

{tags}: tags associated with the group

**Response:**

HTTP 200 OK

- api/v1/groups/search?name=tempora et qui
```json
[
  {
    "id": 2,
    "name": "qui",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:44",
    "updated_at": "2016-07-12 15:37:44",
    "deleted_at": null,
    "tags": [
      {
        "name": "id"
      },
      {
        "name": "voluptatem"
      },
      {
        "name": "dignissimos"
      }
    ]
  },
  {
    "id": 23,
    "name": "tempora",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "tags": [
      {
        "name": "quis"
      },
      {
        "name": "atque"
      },
      {
        "name": "cupiditate"
      }
    ]
  },
  {
    "id": 25,
    "name": "et",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "tags": []
  }
]
```

- api/v1/groups/search?tags=esse magni
```json
[
  {
    "id": 4,
    "name": "voluptas",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:44",
    "updated_at": "2016-07-12 15:37:44",
    "deleted_at": null,
    "tags": [
      {
        "name": "esse"
      }
    ]
  },
  {
    "id": 5,
    "name": "sapiente",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:44",
    "updated_at": "2016-07-12 15:37:44",
    "deleted_at": null,
    "tags": [
      {
        "name": "sint"
      },
      {
        "name": "magni"
      }
    ]
  }
]
```

- api/v1/groups/search?name=tempora et qui&tags=esse magni
```json
[
  {
    "id": 2,
    "name": "qui",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:44",
    "updated_at": "2016-07-12 15:37:44",
    "deleted_at": null,
    "tags": [
      {
        "name": "id"
      },
      {
        "name": "voluptatem"
      },
      {
        "name": "dignissimos"
      }
    ]
  },
  {
    "id": 4,
    "name": "voluptas",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:44",
    "updated_at": "2016-07-12 15:37:44",
    "deleted_at": null,
    "tags": [
      {
        "name": "esse"
      }
    ]
  },
  {
    "id": 5,
    "name": "sapiente",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:44",
    "updated_at": "2016-07-12 15:37:44",
    "deleted_at": null,
    "tags": [
      {
        "name": "sint"
      },
      {
        "name": "magni"
      }
    ]
  },
  {
    "id": 23,
    "name": "tempora",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "tags": [
      {
        "name": "quis"
      },
      {
        "name": "atque"
      },
      {
        "name": "cupiditate"
      }
    ]
  },
  {
    "id": 25,
    "name": "et",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "tags": []
  }
]
```
---

### GET api/v1/users
Retrieve list of Users

**Request Parameters:**
None

**Response:**

HTTP 200 OK
```json
[
  {
    "id": 1,
    "ivle_id": "r5363060",
    "name": "Dr. Anibal Sawayn",
    "email": "weissnat.asha@hotmail.com",
    "gender": "Male",
    "faculty": "Consectetur quia facere.",
    "first_major": "Aut quaerat quia quis delectus.",
    "second_major": "Asperiores ratione sequi sit.",
    "matriculation_year": "1972",
    "last_seen_at": "1978-01-09 18:27:25",
    "last_sync_at": "1991-08-14 00:57:43",
    "created_at": "2016-07-12 15:37:43",
    "updated_at": "2016-07-12 15:37:43"
  },
  {
    "id": 2,
    "ivle_id": "o4135193",
    "name": "Anahi Parisian",
    "email": "abigayle81@boyer.com",
    "gender": "Female",
    "faculty": "Qui voluptas vero.",
    "first_major": "Consequatur soluta reprehenderit.",
    "second_major": "Quasi consectetur blanditiis nisi aut.",
    "matriculation_year": "2009",
    "last_seen_at": "1990-06-29 08:50:17",
    "last_sync_at": "2000-09-10 12:06:09",
    "created_at": "2016-07-12 15:37:43",
    "updated_at": "2016-07-12 15:37:43"
  },
  {
    "id": 3,
    "ivle_id": "v1162154",
    "name": "Prudence Douglas",
    "email": "ybecker@gmail.com",
    "gender": "Female",
    "faculty": "Nemo vero ullam voluptatibus.",
    "first_major": "Placeat aliquam tenetur assumenda.",
    "second_major": "Voluptatibus soluta velit sint.",
    "matriculation_year": "1980",
    "last_seen_at": "2009-10-13 21:51:37",
    "last_sync_at": "2007-09-03 14:25:38",
    "created_at": "2016-07-12 15:37:43",
    "updated_at": "2016-07-12 15:37:43"
  }]
```

---

### GET api/v1/users/{user_id}
Retrieve a User profile

**Request Parameters:**

URL:

{user_id}: ID of the user

**Response:**

HTTP 200 OK
```json
{
  "id": 2,
  "ivle_id": "o4135193",
  "name": "Anahi Parisian",
  "email": "abigayle81@boyer.com",
  "gender": "Female",
  "faculty": "Qui voluptas vero.",
  "first_major": "Consequatur soluta reprehenderit.",
  "second_major": "Quasi consectetur blanditiis nisi aut.",
  "matriculation_year": "2009",
  "last_seen_at": "1990-06-29 08:50:17",
  "last_sync_at": "2000-09-10 12:06:09",
  "created_at": "2016-07-12 15:37:43",
  "updated_at": "2016-07-12 15:37:43"
}
```

---

### GET api/v1/users/{user_id}/groups
Retrieve list of Groups a particular User belongs to

**Request Parameters:**

URL:

{user_id}: ID of the user

**Response:**

HTTP 200 OK
```json
[
  {
    "id": 16,
    "name": "temporibus",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "pivot": {
      "user_id": 2,
      "group_id": 16
    }
  },
  {
    "id": 18,
    "name": "fugiat",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "pivot": {
      "user_id": 2,
      "group_id": 18
    }
  },
  {
    "id": 21,
    "name": "fugiat",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "pivot": {
      "user_id": 2,
      "group_id": 21
    }
  }
]
```

---

### GET api/v1/users/{user_id}/groups/recommends
Retrieve list of suggested group to that particular user with {user_id}, match by common module within each group members, excluding the one he/she already joined.

**Request Parameters:**

URL:

{user_id}: ID of the user

**Response:**

HTTP 200 OK

eg: api/v1/users/2/groups/recommends
```json
[
  {
    "group_id": 2,
    "name": "qui si en",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 6,
    "matching_modules_name": [
      "Qui repudiandae modi ipsa.",
      "Vel rerum vero debitis eaque.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Fuga incidunt voluptatibus id.",
      "Ipsum voluptatum ipsum quia.",
      "Aut magnam perferendis alias laboriosam velit."
    ]
  },
  {
    "group_id": 3,
    "name": "hic",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 7,
    "matching_modules_name": [
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Ipsum voluptatum ipsum quia.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Qui repudiandae modi ipsa.",
      "Aut magnam perferendis alias laboriosam velit.",
      "Vel rerum vero debitis eaque.",
      "Fuga incidunt voluptatibus id."
    ]
  },
  {
    "group_id": 4,
    "name": "voluptas",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 4,
    "matching_modules_name": [
      "Aut magnam perferendis alias laboriosam velit.",
      "Qui repudiandae modi ipsa.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Vel rerum vero debitis eaque."
    ]
  },
  {
    "group_id": 5,
    "name": "sapiente",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 5,
    "matching_modules_name": [
      "Ipsum voluptatum ipsum quia.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Fuga incidunt voluptatibus id.",
      "Qui repudiandae modi ipsa."
    ]
  },
  {
    "group_id": 6,
    "name": "ut",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 5,
    "matching_modules_name": [
      "Aut magnam perferendis alias laboriosam velit.",
      "Qui repudiandae modi ipsa.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Ipsum voluptatum ipsum quia.",
      "Vel rerum vero debitis eaque."
    ]
  },
  {
    "group_id": 7,
    "name": "veniam",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 4,
    "matching_modules_name": [
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Ipsum voluptatum ipsum quia.",
      "Fuga incidunt voluptatibus id.",
      "Aut magnam perferendis alias laboriosam velit."
    ]
  },
  {
    "group_id": 8,
    "name": "veniam",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 5,
    "matching_modules_name": [
      "Vel rerum vero debitis eaque.",
      "Fuga incidunt voluptatibus id.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Ipsum voluptatum ipsum quia.",
      "Aut magnam perferendis alias laboriosam velit."
    ]
  },
  {
    "group_id": 9,
    "name": "harum",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 6,
    "matching_modules_name": [
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Ipsum voluptatum ipsum quia.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Qui repudiandae modi ipsa.",
      "Aut magnam perferendis alias laboriosam velit.",
      "Fuga incidunt voluptatibus id."
    ]
  },
  {
    "group_id": 10,
    "name": "recusandae",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 7,
    "matching_modules_name": [
      "Ipsum voluptatum ipsum quia.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Fuga incidunt voluptatibus id.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Aut magnam perferendis alias laboriosam velit.",
      "Qui repudiandae modi ipsa.",
      "Vel rerum vero debitis eaque."
    ]
  },
  {
    "group_id": 11,
    "name": "dolor",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 3,
    "matching_modules_name": [
      "Vel rerum vero debitis eaque.",
      "Aut magnam perferendis alias laboriosam velit.",
      "Ipsum voluptatum ipsum quia."
    ]
  },
  {
    "group_id": 12,
    "name": "labore",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 5,
    "matching_modules_name": [
      "Qui repudiandae modi ipsa.",
      "Vel rerum vero debitis eaque.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Fuga incidunt voluptatibus id.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae."
    ]
  },
  {
    "group_id": 13,
    "name": "dignissimos",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 1,
    "matching_modules_name": [
      "Qui repudiandae modi ipsa."
    ]
  },
  {
    "group_id": 14,
    "name": "sed",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 7,
    "matching_modules_name": [
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Ipsum voluptatum ipsum quia.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Qui repudiandae modi ipsa.",
      "Aut magnam perferendis alias laboriosam velit.",
      "Vel rerum vero debitis eaque.",
      "Fuga incidunt voluptatibus id."
    ]
  },
  {
    "group_id": 15,
    "name": "sed",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 6,
    "matching_modules_name": [
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Ipsum voluptatum ipsum quia.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Qui repudiandae modi ipsa.",
      "Aut magnam perferendis alias laboriosam velit.",
      "Vel rerum vero debitis eaque."
    ]
  },
  {
    "group_id": 17,
    "name": "molestias",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 3,
    "matching_modules_name": [
      "Ipsum voluptatum ipsum quia.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Fuga incidunt voluptatibus id."
    ]
  },
  {
    "group_id": 19,
    "name": "eos",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 4,
    "matching_modules_name": [
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Fuga incidunt voluptatibus id.",
      "Qui repudiandae modi ipsa."
    ]
  },
  {
    "group_id": 20,
    "name": "doloremque",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 5,
    "matching_modules_name": [
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Fuga incidunt voluptatibus id.",
      "Qui repudiandae modi ipsa.",
      "Vel rerum vero debitis eaque."
    ]
  },
  {
    "group_id": 22,
    "name": "alias",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 5,
    "matching_modules_name": [
      "Qui repudiandae modi ipsa.",
      "Vel rerum vero debitis eaque.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Fuga incidunt voluptatibus id.",
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae."
    ]
  },
  {
    "group_id": 23,
    "name": "tempora",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 0,
    "matching_modules_name": []
  },
  {
    "group_id": 24,
    "name": "molestiae",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 7,
    "matching_modules_name": [
      "Rerum rerum incidunt in officiis recusandae tempora alias vitae.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Fuga incidunt voluptatibus id.",
      "Qui repudiandae modi ipsa.",
      "Vel rerum vero debitis eaque.",
      "Ipsum voluptatum ipsum quia.",
      "Aut magnam perferendis alias laboriosam velit."
    ]
  },
  {
    "group_id": 25,
    "name": "et",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 6,
    "matching_modules_name": [
      "Ipsum voluptatum ipsum quia.",
      "Aut magnam perferendis alias laboriosam velit.",
      "Vel rerum vero debitis eaque.",
      "Delectus debitis nostrum adipisci aut illum commodi.",
      "Qui repudiandae modi ipsa.",
      "Fuga incidunt voluptatibus id."
    ]
  },
  {
    "group_id": 31,
    "name": "My new study group test admin1",
    "type": "study",
    "description": "lorem ipsum",
    "date_happening": "2016-06-10 15:04:47",
    "venue": "soc",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 0,
    "matching_modules_name": []
  },
  {
    "group_id": 32,
    "name": "My new study group test admin1",
    "type": "study",
    "description": "lorem ipsum",
    "date_happening": "2016-06-10 15:04:47",
    "venue": "soc",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 0,
    "matching_modules_name": []
  },
  {
    "group_id": 33,
    "name": "My new study group",
    "type": "study",
    "description": "lorem ipsum",
    "date_happening": "2016-06-10 15:04:47",
    "venue": "soc",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 0,
    "matching_modules_name": []
  },
  {
    "group_id": 34,
    "name": "My new study group",
    "type": "study",
    "description": "lorem ipsum",
    "date_happening": "2016-06-10 15:04:47",
    "venue": "soc",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 0,
    "matching_modules_name": []
  },
  {
    "group_id": 35,
    "name": "My new study group",
    "type": "study",
    "description": "lorem ipsum",
    "date_happening": "2016-06-10 15:04:47",
    "venue": "soc",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 0,
    "matching_modules_name": []
  },
  {
    "group_id": 36,
    "name": "My new study group",
    "type": "study",
    "description": "lorem ipsum",
    "date_happening": "2016-06-10 15:04:47",
    "venue": "soc",
    "current_logged_in_user_has_joined": false,
    "matching_modules_count": 0,
    "matching_modules_name": []
  }
]
```

---

### GET api/v1/users/{user_id}/modulesTaken
Retrieve a User's modules taken

**Request Parameters:**

URL:

{user_id}: ID of the user

**Response:**

HTTP 200 OK
```json
[
  {
    "user_id": 2,
    "module_id": 7,
    "year_taken": 1974,
    "semester_taken": 2,
    "module": {
      "id": 7,
      "module_code": "kz7022",
      "module_title": "Qui repudiandae modi ipsa."
    }
  },
  {
    "user_id": 2,
    "module_id": 6,
    "year_taken": 1989,
    "semester_taken": 1,
    "module": {
      "id": 6,
      "module_code": "hb3944",
      "module_title": "Delectus debitis nostrum adipisci aut illum commodi."
    }
  },
  {
    "user_id": 2,
    "module_id": 3,
    "year_taken": 2008,
    "semester_taken": 1,
    "module": {
      "id": 3,
      "module_code": "ua6654",
      "module_title": "Vel rerum vero debitis eaque."
    }
  },
  {
    "user_id": 2,
    "module_id": 2,
    "year_taken": 1992,
    "semester_taken": 1,
    "module": {
      "id": 2,
      "module_code": "uq4629",
      "module_title": "Ipsum voluptatum ipsum quia."
    }
  },
  {
    "user_id": 2,
    "module_id": 5,
    "year_taken": 2008,
    "semester_taken": 2,
    "module": {
      "id": 5,
      "module_code": "ra538",
      "module_title": "Aut magnam perferendis alias laboriosam velit."
    }
  },
  {
    "user_id": 2,
    "module_id": 4,
    "year_taken": 1992,
    "semester_taken": 1,
    "module": {
      "id": 4,
      "module_code": "rn2716",
      "module_title": "Fuga incidunt voluptatibus id."
    }
  },
  {
    "user_id": 2,
    "module_id": 8,
    "year_taken": 1974,
    "semester_taken": 1,
    "module": {
      "id": 8,
      "module_code": "lc3532",
      "module_title": "Rerum rerum incidunt in officiis recusandae tempora alias vitae."
    }
  }
]
```

---

### GET api/v1/users/{user_id}/posts
Retrieve posts belongs to a user by user_id

**Request Parameters:**

URL:

{user_id}: ID of the user

**Response:**

HTTP 200 OK
```json
[
  {
    "id": 10,
    "content": "Eos illo itaque iusto doloremque. Cumque cupiditate error voluptatibus dolorem similique aut reiciendis. Fugit cupiditate est voluptatum non et hic. Fuga aut laborum ut eveniet vel quis.",
    "user_id": 3,
    "group_id": 20,
    "created_at": "2016-07-19 11:11:05",
    "updated_at": "2016-07-19 11:11:05"
  },
  {
    "id": 17,
    "content": "Nostrum sed a ullam possimus aut. Quis architecto necessitatibus molestias dolor error. Eaque neque voluptatem odio ipsa. Ipsum non sit et harum. Sed exercitationem eveniet id sit ut saepe ut.",
    "user_id": 3,
    "group_id": 16,
    "created_at": "2016-07-19 11:11:05",
    "updated_at": "2016-07-19 11:11:05"
  },
  {
    "id": 26,
    "content": "Nulla labore non nulla magni. Ad labore sed et. Maiores tempore blanditiis quidem consectetur. Id deserunt consectetur illum fugiat quis fuga doloribus quisquam.",
    "user_id": 3,
    "group_id": 25,
    "created_at": "2016-07-19 11:11:05",
    "updated_at": "2016-07-19 11:11:05"
  },
  {
    "id": 41,
    "content": "Aperiam dolorem ex et non placeat impedit. Aperiam laborum doloribus quibusdam reiciendis dignissimos sint praesentium. Quam porro dolores officiis dolor porro.",
    "user_id": 3,
    "group_id": 3,
    "created_at": "2016-07-19 11:11:06",
    "updated_at": "2016-07-19 11:11:06"
  },
  {
    "id": 47,
    "content": "Veniam vel molestiae et occaecati nulla labore. Ut facilis laboriosam voluptatem consequatur error nihil sunt. Architecto impedit qui culpa beatae debitis. Omnis est ducimus molestiae.",
    "user_id": 3,
    "group_id": 19,
    "created_at": "2016-07-19 11:11:07",
    "updated_at": "2016-07-19 11:11:07"
  },
  {
    "id": 48,
    "content": "Incidunt iure ut vero et dolores quos. Rerum et velit cumque beatae optio. Illum nam ut incidunt sed porro suscipit earum. Harum provident qui molestiae libero numquam dicta quibusdam.",
    "user_id": 3,
    "group_id": 24,
    "created_at": "2016-07-19 11:11:07",
    "updated_at": "2016-07-19 11:11:07"
  },
  {
    "id": 83,
    "content": "Et quidem at dicta rerum rem ea ut atque. Est beatae omnis est architecto. Exercitationem tempore repudiandae quos magni aspernatur velit unde est.",
    "user_id": 3,
    "group_id": 24,
    "created_at": "2016-07-19 11:11:09",
    "updated_at": "2016-07-19 11:11:09"
  }
]
```
---

### POST api/v1/posts
Create a new Post

**Request Parameters:**

Body:

```json
{
"group_id": 2,
"content": "lorem ipsum dollar sit amet."
}
```

**Response:**

HTTP 201 CREATED
```json
{
  "message": "Post for Group 2 created."
  "id": 2
}
```

---

### GET api/v1/posts/{post_id}
Retrieve a post by post_id

**Request Parameters:**

{post_id}: Post's ID

**Response:**

HTTP 200 OK
```json
{
  "id": 2,
  "content": "Voluptas veritatis est aut aut dolore ducimus incidunt. Sunt dicta sapiente corrupti est consectetur quisquam. In nihil beatae ea et. Ex exercitationem eos fugit est est nobis.",
  "user_id": 14,
  "group_id": 12,
  "created_at": "2016-07-19 11:11:04",
  "updated_at": "2016-07-19 11:11:04"
}
```

---

### GET api/v1/me
Retrieve current authenticated User

**Request Parameters:**
None

**Response:**

HTTP 200 OK
```json
{
  "id": 2,
  "ivle_id": "o4135193",
  "name": "Anahi Parisian",
  "email": "abigayle81@boyer.com",
  "gender": "Female",
  "faculty": "Qui voluptas vero.",
  "first_major": "Consequatur soluta reprehenderit.",
  "second_major": "Quasi consectetur blanditiis nisi aut.",
  "matriculation_year": "2009",
  "last_seen_at": "1990-06-29 08:50:17",
  "last_sync_at": "2000-09-10 12:06:09",
  "created_at": "2016-07-12 15:37:43",
  "updated_at": "2016-07-12 15:37:43"
}
```

---

### PUT api/v1/me
Retrieve current authenticated User

**Request Parameters:**

Body:

```json
{
  "intro": "omg wtf bbq so awsome!!!"
}
```

**Response:**

HTTP 200 OK
```json
{
  "message": "User updated."
}
```


---

### GET api/v1/me/groups
Retrieve list of Groups that current authenticated User belongs to

**Request Parameters:**
None

**Response:**

HTTP 200 OK
```json
[
  {
    "id": 16,
    "name": "temporibus",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "pivot": {
      "user_id": 2,
      "group_id": 16
    }
  },
  {
    "id": 18,
    "name": "fugiat",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "pivot": {
      "user_id": 2,
      "group_id": 18
    }
  },
  {
    "id": 21,
    "name": "fugiat",
    "type": "",
    "description": "",
    "date_happening": "0000-00-00 00:00:00",
    "venue": "",
    "created_at": "2016-07-12 15:37:45",
    "updated_at": "2016-07-12 15:37:45",
    "deleted_at": null,
    "pivot": {
      "user_id": 2,
      "group_id": 21
    }
  }
]
```

---

### POST api/v1/me/groups/{group_id}/join
Current User join an existing group.

**Request Parameters:**

URL:

{group_id}: ID of the group to join

**Response:**

HTTP 200 OK
```json
{
  "message": "User 1 joined group 3"
}
```

---

### POST api/v1/me/groups/{group_id}/leave
Current User leave an existing group.

**Request Parameters:**

URL:

{group_id}: ID of the group to join

**Response:**

HTTP 200 OK
```json
{
  "message": "User 1 leave group 3"
}
```

---

### GET api/v1/me/posts
Retrieve posts belongs to the current authenticated User has taken

**Request Parameters:**
None

**Response:**

HTTP 200 OK
```json
[
  {
    "id": 101,
    "content": "lorem ipsum dollar sit amet.",
    "user_id": 16,
    "group_id": 2,
    "created_at": "2016-07-20 20:11:36",
    "updated_at": "2016-07-20 20:11:36"
  },
  {
    "id": 102,
    "content": "lorem ipsum dollar sit amet.",
    "user_id": 16,
    "group_id": 2,
    "created_at": "2016-07-20 20:11:37",
    "updated_at": "2016-07-20 20:11:37"
  },
  {
    "id": 103,
    "content": "lorem ipsum dollar sit amet.",
    "user_id": 16,
    "group_id": 2,
    "created_at": "2016-07-20 20:12:04",
    "updated_at": "2016-07-20 20:12:04"
  },
  {
    "id": 104,
    "content": "lorem ipsum dollar sit amet.",
    "user_id": 16,
    "group_id": 2,
    "created_at": "2016-07-20 20:12:04",
    "updated_at": "2016-07-20 20:12:04"
  }
]
```

---

### GET api/v1/me/modulesTaken
Retrieve list of Modules that current authenticated User has taken

**Request Parameters:**
None

**Response:**

HTTP 200 OK
```json
[
  {
    "user_id": 2,
    "module_id": 7,
    "year_taken": 1974,
    "semester_taken": 2,
    "module": {
      "id": 7,
      "module_code": "kz7022",
      "module_title": "Qui repudiandae modi ipsa."
    }
  },
  {
    "user_id": 2,
    "module_id": 6,
    "year_taken": 1989,
    "semester_taken": 1,
    "module": {
      "id": 6,
      "module_code": "hb3944",
      "module_title": "Delectus debitis nostrum adipisci aut illum commodi."
    }
  },
  {
    "user_id": 2,
    "module_id": 3,
    "year_taken": 2008,
    "semester_taken": 1,
    "module": {
      "id": 3,
      "module_code": "ua6654",
      "module_title": "Vel rerum vero debitis eaque."
    }
  },
  {
    "user_id": 2,
    "module_id": 2,
    "year_taken": 1992,
    "semester_taken": 1,
    "module": {
      "id": 2,
      "module_code": "uq4629",
      "module_title": "Ipsum voluptatum ipsum quia."
    }
  },
  {
    "user_id": 2,
    "module_id": 5,
    "year_taken": 2008,
    "semester_taken": 2,
    "module": {
      "id": 5,
      "module_code": "ra538",
      "module_title": "Aut magnam perferendis alias laboriosam velit."
    }
  },
  {
    "user_id": 2,
    "module_id": 4,
    "year_taken": 1992,
    "semester_taken": 1,
    "module": {
      "id": 4,
      "module_code": "rn2716",
      "module_title": "Fuga incidunt voluptatibus id."
    }
  },
  {
    "user_id": 2,
    "module_id": 8,
    "year_taken": 1974,
    "semester_taken": 1,
    "module": {
      "id": 8,
      "module_code": "lc3532",
      "module_title": "Rerum rerum incidunt in officiis recusandae tempora alias vitae."
    }
  }
]
```

---

### GET api/v1/me/resync
Resynchronize & cache current user info from IVLE

**Request Parameters:**
None

**Response:**

HTTP 200 OK
```json
{
  "message": "User e0001573 synchronized.",
  "last_sync_at": "2016-07-13 11:29:06"
}
```
