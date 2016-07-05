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

 Status | Endpoint | HTTP Method | Description | Request Parameters | Response Parameters 
--------|----------|-------------|-------------|--------------------|---------------------
 O | api/v1/groups | GET | Retrieve list of available Groups ||
 O | api/v1/groups | POST | Create a new Group ||
 O | api/v1/groups/{group_id} | GET | Retrieve a Group by id ||
 O | api/v1/groups/{group_id} | PUT | Update a Group by id ||
 O | api/v1/groups/{group_id}/users | GET | Retrieve all users belongs to a specific Group ||
 O | api/v1/groups/{group_id}/tags | GET | Retrieve all tags belongs to a specific Group ||
 O | api/v1/users | GET | Retrieve list of Users ||
 O | api/v1/users/{user_id}/groups | GET | Retrieve list of Groups a particular User belongs to ||
 O | api/v1/users/{user_id} | GET | Retrieve a User profile ||
 O | api/v1/me | GET | Retrieve current authenticated User ||
 O | api/v1/me/groups | GET | Retrieve list of Groups that current authenticated User belongs to ||
 O | api/v1/me/groups/{group_id}/join | POST | Current User join an existing group. ||
 O | api/v1/me/groups/{group_id}/leave | POST | Current User leave an existing group. ||
 O | api/v1/me/modulesTaken | GET | Retrieve list of Modules that current authenticated User has taken ||
 O | api/v1/me/resync | GET | Resynchronize & cache current user info from IVLE ||