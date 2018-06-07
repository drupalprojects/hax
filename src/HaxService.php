<?php

namespace Drupal\hax;

/**
 * Class HaxService.
 *
 * @package Drupal\hax
 */
class HaxService {

  /**
   * Load app store.
   *
   * @param array $api_keys
   *   Array of API keys per service.
   *
   * @return array
   *   An array of app store definitions based on passing in the api keys for
   *   the ones we have baked in support for.
   */
  public function loadBaseAppStore(array $api_keys = []) {
    $json = [];

    // YouTube.
    if (isset($api_keys['youtube'])) {
      $json_string = '{
        "details": {
          "title": "Youtube",
          "icon": "av:play-arrow",
          "color": "red",
          "author": "Google, Youtube LLC",
          "description": "The most popular online video sharing and remix site.",
          "status": "available",
          "tags": ["video", "crowdsourced"]
        },
        "connection": {
            "protocol": "https",
            "url": "www.googleapis.com/youtube/v3",
            "data": {
              "key": "' . $api_keys['youtube'] . '"
            },
            "operations": {
              "browse": {
                "method": "GET",
                "endPoint": "search",
                "pagination": {
                  "style": "page",
                  "props": {
                    "previous": "prevPageToken",
                    "next": "nextPageToken",
                    "total_items": "pageInfo.totalResults"
                  }
                },
                "search": {
                  "q": {
                    "title": "Search",
                    "type": "string"
                  }
                },
                "data": {
                  "part": "snippet",
                  "type": "video",
                  "maxResults": "20"
                },

                  "url": "https://www.youtube.com/watch?v=",

                "resultMap": {
                  "defaultGizmoType": "video",
                  "items": "items",
                  "preview": {
                    "title": "snippet.title",
                    "details": "snippet.description",
                    "image": "snippet.thumbnails.default.url",
                    "id": "id.videoId"
                  },
                  "gizmo": {
                    "title": "snippet.title",
                    "description": "snippet.description",
                    "id": "id.videoId",
                    "_url_source": "https://www.youtube.com/watch?v=<%= id %>",
                    "caption": "snippet.description",
                    "citation": "snippet.channelTitle"
                  }
                }
              }
            }
        }
      }';
      $tmp = json_decode($json_string);
      array_push($json, $tmp);
    }

    // Meme Generator.
    if (isset($api_keys['memegenerator'])) {
      $json_string = '{
        "details": {
          "title": "Meme generator",
          "icon": "android",
          "color": "blue",
          "author": "Meme generator",
          "description": "A search engine of popular memes.",
          "status": "available",
          "tags": ["picture", "crowdsourced", "image", "meme"]
        },
        "connection": {
          "protocol": "http",
          "url": "version1.api.memegenerator.net",
          "data": {
            "apiKey": "' . $api_keys['memegenerator'] . '"
          },
          "operations": {
            "browse": {
              "method": "GET",
              "endPoint": "Generators_Search",
              "pagination": {
                "style": "page",
                "props": {
                  "previous": "prevPageToken",
                  "next": "nextPageToken",
                  "total_items": "pageInfo.totalResults"
                }
              },
              "search": {
                "q": {
                  "title": "Search",
                  "type": "string"
                }
              },
              "data": {
                "pageIndex":"0",
                "pageSize":"20"
              },
              "resultMap": {
                "defaultGizmoType": "image",
                "items": "result",
                "preview": {
                  "title": "displayName",
                  "details": "",
                  "image": "imageUrl",
                  "id": "imageID"
                },
                "gizmo": {
                  "title": "displayName",
                  "id": "imageID",
                  "source": "imageUrl"
                }
              }
            }
          }
        }
      }';
      $tmp = json_decode($json_string);
      array_push($json, $tmp);
    }

    // Vimeo.
    if (isset($api_keys['vimeo'])) {
      $json_string = '{
        "details": {
          "title": "Vimeo",
          "icon": "av:play-circle-filled",
          "color": "blue",
          "author": "Vimeo Inc.",
          "description": "A high quality video sharing community.",
          "status": "available",
          "tags": ["video", "crowdsourced"]
        },
        "connection": {
          "protocol": "https",
          "url": "api.vimeo.com",
          "data": {
            "access_token": "' . $api_keys['vimeo'] . '"
          },
          "operations": {
            "browse": {
              "method": "GET",
              "endPoint": "videos",
              "pagination": {
                "style": "link",
                "props": {
                  "first": "paging.first",
                  "next": "paging.next",
                  "previous": "paging.previous",
                  "last": "paging.last"
                }
              },
              "search": {
                "query": {
                  "title": "Search",
                  "type": "string"
                }
              },
              "data": {
                "direction": "asc",
                "sort": "alphabetical",
                "filter": "CC",
                "per_page": "20"
              },
              "resultMap": {
                "defaultGizmoType": "video",
                "items": "data",
                "preview": {
                  "title": "name",
                  "details": "description",
                  "image": "pictures.sizes.1.link",
                  "id": "id"
                },
                "gizmo": {
                  "_url_source": "https://vimeo.com<%= id %>",
                  "id": "uri",
                  "title": "title",
                  "caption": "description",
                  "description": "description",
                  "citation": "user.name"
                }
              }
            }
          }
        }
      }';
      $tmp = json_decode($json_string);
      array_push($json, $tmp);
    }

    // Giphy.
    if (isset($api_keys['giphy'])) {
      $json_string = '{
        "details": {
          "title": "Giphy",
          "icon": "gif",
          "color": "green",
          "author": "Giphy",
          "description": "Crowd sourced memes via animated gifs.",
          "status": "available",
          "tags": ["gif", "crowdsourced", "meme"]
        },
        "connection": {
          "protocol": "https",
          "url": "api.giphy.com",
          "data": {
            "api_key": "' . $api_keys['giphy'] . '"
          },
          "operations": {
            "browse": {
              "method": "GET",
              "endPoint": "v1/gifs/search",
              "pagination": {
                "style": "offset",
                "props": {
                  "offset": "pagination.offset",
                  "total": "pagination.total_count",
                  "count": "pagination.count"
                }
              },
              "search": {
                "q": {
                  "title": "Search",
                  "type": "string"
                },
                "rating": {
                  "title": "Rating",
                  "type": "string",
                  "component": {
                    "name": "dropdown-select",
                    "slot": "<paper-item value=\'Y\'>Y</paper-item><paper-item value=\'G\'>G</paper-item><paper-item value=\'PG\'>PG</paper-item><paper-item value=\'PG-13\'>PG-13</paper-item><paper-item value=\'R\'>R</paper-item>"
                  }
                },
                "lang": {
                  "title": "Language",
                  "type": "string",
                  "component": {
                    "name": "dropdown-select",
                    "slot": "<paper-item value=\'en\'>en</paper-item><paper-item value=\'es\'>es</paper-item><paper-item value=\'pt\'>pt</paper-item><paper-item value=\'id\'>id</paper-item><paper-item value=\'fr\'>fr</paper-item><paper-item value=\'ar\'>ar</paper-item><paper-item value=\'tr\'>tr</paper-item><paper-item value=\'th\'>th</paper-item><paper-item value=\'vi\'>vi</paper-item><paper-item value=\'de\'>de</paper-item><paper-item value=\'it\'>it</paper-item><paper-item value=\'ja\'>ja</paper-item><paper-item value=\'zh-CN\'>zh-CN</paper-item><paper-item value=\'zh-TW\'>zh-TW</paper-item><paper-item value=\'ru\'>ru</paper-item><paper-item value=\'ko\'>ko</paper-item><paper-item value=\'pl\'>pl</paper-item><paper-item value=\'nl\'>nl</paper-item><paper-item value=\'ro\'>ro</paper-item><paper-item value=\'hu\'>hu</paper-item><paper-item value=\'sv\'>sv</paper-item><paper-item value=\'cs\'>cs</paper-item><paper-item value=\'hi\'>hi</paper-item><paper-item value=\'bn\'>bn</paper-item><paper-item value=\'da\'>da</paper-item><paper-item value=\'fa\'>fa</paper-item><paper-item value=\'tl\'>tl</paper-item><paper-item value=\'fi\'>fi</paper-item><paper-item value=\'iw\'>iw</paper-item><paper-item value=\'ms\'>ms</paper-item><paper-item value=\'no\'>no</paper-item><paper-item value=\'uk\'>uk</paper-item>"
                  }
                }
              },
              "data": {
                "limit": "20",
                "lang": "en"
              },
              "resultMap": {
                "defaultGizmoType": "image",
                "items": "data",
                "preview": {
                  "title": "title",
                  "details": "description",
                  "image": "images.preview_gif.url",
                  "id": "id"
                },
                "gizmo": {
                  "source": "images.original.url",
                  "source2": "images.480w_still.url",
                  "id": "id",
                  "title": "title",
                  "alt": "title",
                  "caption": "user.display_name",
                  "citation": "user.display_name"
                }
              }
            }
          }
        }
      }';
      $tmp = json_decode($json_string);
      array_push($json, $tmp);
    }

    // Unsplash.
    if (isset($api_keys['unsplash'])) {
      $json_string = '{
        "details": {
          "title": "Unsplash",
          "icon": "image:collections",
          "color": "grey",
          "author": "Unsplash",
          "description": "Crowd sourced, open photos",
          "status": "available",
          "tags": ["images", "crowdsourced", "cc"]
        },
        "connection": {
          "protocol": "https",
          "url": "api.unsplash.com",
          "data": {
            "client_id": "' . $api_keys['unsplash'] . '"
          },
          "operations": {
            "browse": {
              "method": "GET",
              "endPoint": "search/photos",
              "pagination": {
                "style": "link",
                "props": {
                  "first": "paging.first",
                  "next": "paging.next",
                  "previous": "paging.previous",
                  "last": "paging.last"
                }
              },
              "search": {
                "query": {
                  "title": "Search",
                  "type": "string"
                }
              },
              "data": {
              },
              "resultMap": {
                "defaultGizmoType": "image",
                "items": "results",
                "preview": {
                  "title": "",
                  "details": "description",
                  "image": "urls.thumb",
                  "id": "id"
                },
                "gizmo": {
                  "id": "id",
                  "source": "urls.regular",
                  "alt": "description",
                  "caption": "description",
                  "citation": "user.name"
                }
              }
            }
          }
        }
      }';
      $tmp = json_decode($json_string);
      array_push($json, $tmp);
    }

    // Flickr.
    if (isset($api_keys['flickr'])) {
      $json_string = '{
        "details": {
          "title": "Flickr",
          "icon": "image:collections",
          "color": "pink",
          "author": "Yahoo",
          "description": "The original photo sharing platform on the web.",
          "status": "available",
          "rating": "0",
          "tags": ["images", "creative commons", "crowdsourced"]
        },
        "connection": {
          "protocol": "https",
          "url": "api.flickr.com",
          "data": {
            "api_key": "' . $api_keys['flickr'] . '"
          },
          "operations": {
            "browse": {
              "method": "GET",
              "endPoint": "services/rest",
              "pagination": {
                "style": "page",
                "props": {
                  "per_page": "photos.perpage",
                  "total_pages": "photos.pages",
                  "page": "photos.page"
                }
              },
              "search": {
                "text": {
                  "title": "Search",
                  "type": "string"
                },
                "safe_search": {
                  "title": "Safe results",
                  "type": "string",
                  "value": "1",
                  "component": {
                    "name": "dropdown-select",
                    "valueProperty": "value",
                    "slot": "<paper-item value=\'1\'>Safe</paper-item><paper-item value=\'2\'>Moderate</paper-item><paper-item value=\'3\'>Restricted</paper-item>"
                  }
                },
                "license": {
                  "title": "License type",
                  "type": "string",
                  "value": "",
                  "component": {
                    "name": "dropdown-select",
                    "valueProperty": "value",
                    "slot": "<paper-item value=\'\'>Any</paper-item><paper-item value=\'0\'>All Rights Reserved</paper-item><paper-item value=\'4\'>Attribution License</paper-item><paper-item value=\'6\'>Attribution-NoDerivs License</paper-item><paper-item value=\'3\'>Attribution-NonCommercial-NoDerivs License</paper-item><paper-item value=\'2\'>Attribution-NonCommercial License</paper-item><paper-item value=\'1\'>Attribution-NonCommercial-ShareAlike License</paper-item><paper-item value=\'5\'>Attribution-ShareAlike License</paper-item><paper-item value=\'7\'>No known copyright restrictions</paper-item><paper-item value=\'8\'>United States Government Work</paper-item><paper-item value=\'9\'>Public Domain Dedication (CC0)</paper-item><paper-item value=\'10\'>Public Domain Mark</paper-item>"
                  }
                }
              },
              "data": {
                "method": "flickr.photos.search",
                "safe_search": "1",
                "format": "json",
                "per_page": "20",
                "nojsoncallback": "1",
                "extras": "license,description,url_l,url_s"
              },
              "resultMap": {
                "defaultGizmoType": "image",
                "items": "photos.photo",
                "preview": {
                  "title": "title",
                  "details": "description._content",
                  "image": "url_s",
                  "id": "id"
                },
                "gizmo": {
                  "title": "title",
                  "source": "url_l",
                  "alt": "description._content"
                }
              }
            }
          }
        }
      }';
      $tmp = json_decode($json_string);
      array_push($json, $tmp);
    }

    // Pixabay.
    if (isset($api_keys['pixabay'])) {
      $json_string = '{
        "details": {
          "title": "Pixabay images",
          "icon": "places:all-inclusive",
          "color": "orange",
          "author": "Pixabay",
          "description": "Pixabay open image community",
          "status": "available",
          "tags": ["images", "crowdsourced"]
        },
        "connection": {
          "protocol": "https",
          "url": "pixabay.com",
          "data": {
            "key": "' . $api_keys['pixabay'] . '"
          },
          "operations": {
            "browse": {
              "method": "GET",
              "endPoint": "api",
              "pagination": {
                "style": "page",
                "props": {
                  "total_items": "totalHits",
                  "page": "page"
                }
              },
              "search": {
                "q": {
                  "title": "Search",
                  "type": "string"
                }
              },
              "data": {
                "image_type": "photo"
              },
              "resultMap": {
                "defaultGizmoType": "image",
                "items": "hits",
                "preview": {
                  "title": "tags",
                  "details": "user",
                  "image": "previewURL",
                  "id": "id"
                },
                "gizmo": {
                  "source": "webformatURL",
                  "id": "uri",
                  "title": "tags",
                  "caption": "tags",
                  "citation": "user.name"
                }
              }
            }
          }
        }
      }';
      $tmp = json_decode($json_string);
      array_push($json, $tmp);
    }

    // Nasa.
    $json_string = '{
      "details": {
        "title": "NASA",
        "icon": "places:all-inclusive",
        "color": "blue",
        "author": "US Government",
        "description": "The cozmos through one simple API.",
        "status": "available",
        "tags": ["images", "government", "space"]
      },
      "connection": {
        "protocol": "https",
        "url": "images-api.nasa.gov",
        "operations": {
          "browse": {
            "method": "GET",
            "endPoint": "search",
            "pagination": {
              "style": "page",
              "props": {
                "page": "page"
              }
            },
            "search": {
              "q": {
                "title": "Search",
                "type": "string"
              }
            },
            "data": {
              "media_type": "image"
            },
            "resultMap": {
              "defaultGizmoType": "image",
              "items": "collection.items",
              "preview": {
                "title": "data.0.title",
                "details": "data.0.description",
                "image": "links.0.href",
                "id": "links.0.href"
              },
              "gizmo": {
                "id": "links.0.href",
                "source": "links.0.href",
                "title": "data.0.title",
                "caption": "data.0.description",
                "description": "data.0.description",
                "citation": "data.0.photographer",
                "type": "data.0.media_type"
              }
            }
          }
        }
      }
    }';
    $tmp = json_decode($json_string);
    array_push($json, $tmp);

    // Sketchfab.
    $json_string = '{
      "details": {
        "title": "Sketchfab",
        "icon": "icons:3d-rotation",
        "color": "purple",
        "author": "Sketchfab",
        "description": "3D sharing community.",
        "status": "available",
        "rating": "0",
        "tags": ["3D", "creative commons", "crowdsourced"]
      },
      "connection": {
        "protocol": "https",
        "url": "api.sketchfab.com",
        "data": {
          "type": "models"
        },
        "operations": {
          "browse": {
            "method": "GET",
            "endPoint": "v3/search",
            "pagination": {
              "style": "page",
              "props": {
                "per_page": "photos.perpage",
                "total_pages": "photos.pages",
                "page": "photos.page"
              }
            },
            "search": {
              "q": {
                "title": "Search",
                "type": "string"
              },
              "license": {
                "title": "License type",
                "type": "string",
                "value": "",
                "component": {
                  "name": "dropdown-select",
                  "valueProperty": "value",
                  "slot": "<paper-item value=\'\'>Any</paper-item><paper-item value=\'by\'>Attribution</paper-item><paper-item value=\'by-sa\'>Attribution ShareAlike</paper-item><paper-item value=\'by-nd\'>Attribution NoDerivatives</paper-item><paper-item value=\'by-nc\'>Attribution-NonCommercial</paper-item><paper-item value=\'by-nc-sa\'>Attribution NonCommercial ShareAlike</paper-item><paper-item value=\'by-nc-nd\'>Attribution NonCommercial NoDerivatives</paper-item><paper-item value=\'cc0\'>Public Domain Dedication (CC0)</paper-item>"
                }
              }
            },
            "resultMap": {
              "defaultGizmoType": "video",
              "items": "results",
              "preview": {
                "title": "name",
                "details": "description._content",
                "image": "thumbnails.images.2.url",
                "id": "uid"
              },
              "gizmo": {
                "title": "name",
                "source": "embedUrl",
                "alt": "description"
              }
            }
          }
        }
      }
    }';
    $tmp = json_decode($json_string);
    array_push($json, $tmp);

    // Dailymotion.
    $json_string = '{
      "details": {
        "title": "Dailymotion",
        "icon": "av:play-circle-filled",
        "color": "blue",
        "author": "Dailymotion",
        "description": "A crowdsourced video platform that is ad supported.",
        "status": "available",
        "tags": ["video", "crowdsourced"]
      },
      "connection": {
        "protocol": "https",
        "url": "api.dailymotion.com",
        "operations": {
          "browse": {
            "method": "GET",
            "endPoint": "videos",
            "pagination": {
              "style": "page",
              "props": {
                "total_items": "total",
                "total_pages": "total_pages",
                "page": "page"
              }
            },
            "search": {
              "search": {
                "title": "Search",
                "type": "string"
              }
            },
            "data": {
              "fields":"description,embed_url,thumbnail_240_url,title,id",
              "no_live":"1",
              "ssl_assets":"true",
              "sort":"relevance",
              "limit":"20"
            },
            "resultMap": {
              "defaultGizmoType": "video",
              "items": "list",
              "preview": {
                "title": "title",
                "details": "description",
                "image": "thumbnail_240_url",
                "id": "id"
              },
              "gizmo": {
                "title": "title",
                "description": "description",
                "source": "embed_url",
                "alt": "description",
                "caption": "description"
              }
            }
          }
        }
      }
    }';
    $tmp = json_decode($json_string);
    array_push($json, $tmp);

    // Wikipedia.
    $json_string = '{
      "details": {
        "title": "Wikipedia",
        "icon": "account-balance",
        "color": "grey",
        "author": "Wikimedia",
        "description": "Encyclopedia of the world.",
        "status": "available",
        "tags": ["content", "encyclopedia", "wiki"]
      },
      "connection": {
        "protocol": "https",
        "url": "en.wikipedia.org",
        "data": {
          "action":"query",
          "list":"search",
          "format":"json"
        },
        "operations": {
          "browse": {
            "method": "GET",
            "endPoint": "w/api.php",
            "pagination": {
              "style": "offset",
              "props": {
                "offset": "sroffset"
              }
            },
            "search": {
              "srsearch": {
                "title": "Search",
                "type": "string"
              }
            },
            "data": {
            },
            "resultMap": {
              "defaultGizmoType": "content",
              "items": "query.search",
              "preview": {
                "title": "title",
                "details": "snippet",
                "image": "pageid",
                "id": "pageid"
              },
              "gizmo": {
                "_url_source": "https://en.wikipedia.org/wiki/<%= id %>",
                "id": "title",
                "title": "title",
                "caption": "snippet",
                "description": "snippet"
              }
            }
          }
        }
      }
    }';
    $tmp = json_decode($json_string);
    array_push($json, $tmp);

    // Cc-mixter.
    $json_string = '{
      "details": {
        "title": "CC Mixter",
        "icon": "av:library-music",
        "color": "purple",
        "author": "CC Mixter",
        "description": "User submitted audio files and music.",
        "status": "available",
        "tags": ["audio", "crowdsourced"]
      },
      "connection": {
        "protocol": "http",
        "url": "ccmixter.org",
        "data": {
          "format":"json",
          "sort":"name",
          "limit":"20"
        },
        "operations": {
          "browse": {
            "method": "GET",
            "endPoint": "api/query",
            "pagination": {
              "style": "link",
              "props": {
                "first": "paging.first",
                "next": "paging.next",
                "previous": "paging.previous",
                "last": "paging.last"
              }
            },
            "search": {
              "tags": {
                "title": "Search",
                "type": "string"
              }
            },
            "data": {
              "direction": "asc",
              "sort": "alphabetical",
              "filter": "CC",
              "per_page": "20"
            },
            "resultMap": {
              "defaultGizmoType": "audio",
              "items": "",
              "preview": {
                "title": "upload_name",
                "details": "upload_description_plain",
                "image": "license_logo_url",
                "id": "upload_id"
              },
              "gizmo": {
                "source": "files.0.download_url",
                "id": "upload_id",
                "title": "upload_name",
                "caption": "upload_description_plain",
                "description": "upload_description_plain",
                "citation": "license_name"
              }
            }
          }
        }
      }
    }';
    $tmp = json_decode($json_string);
    array_push($json, $tmp);

    // Codepen.
    $json_string = '{
      "details": {
        "title": "Codepen.io",
        "icon": "code",
        "color": "green",
        "author": "Code pen",
        "description": "HTML / CSS / JS sharing community",
        "status": "available",
        "rating": "0",
        "tags": ["code", "development", "html", "js", "crowdsourced"]
      },
      "connection": {
        "protocol": "https",
        "url": "cpv2api.com",
        "operations": {
          "browse": {
            "method": "GET",
            "endPoint": "search/pens",
            "pagination": {
              "style": "page",
              "props": {
                "per_page": "photos.perpage",
                "total_pages": "photos.pages",
                "page": "photos.page"
              }
            },
            "search": {
              "q": {
                "title": "Search",
                "type": "string"
              }
            },
            "resultMap": {
              "defaultGizmoType": "video",
              "items": "data",
              "preview": {
                "title": "title",
                "details": "details",
                "image": "images.small",
                "id": "id"
              },
              "gizmo": {
                "_url_source": "https://codepen.io/fchazal/embed/<%= id %>/?theme-id=0&default-tab=html,result&embed-version=2",
                "id": "id",
                "image": "images.large",
                "title": "title",
                "caption": "details",
                "description": "details"
              }
            }
          }
        }
      }
    }';
    $tmp = json_decode($json_string);
    array_push($json, $tmp);

    return $json;
  }

  /**
   * Supported apps.
   *
   * Return an array of the base app keys we support. This can reduce the time
   * to integrate with other solutions.
   *
   * @return array
   *   Service names keyed by their key name.
   */
  public function baseSupportedApps() {
    return array(
      'youtube' => array(
        'name' => 'YouTube',
        'docs' => 'https://developers.google.com/youtube/v3/getting-started',
      ),
      'memegenerator' => array(
        'name' => 'Meme generator',
        'docs' => 'https://memegenerator.net/Api',
      ),
      'vimeo' => array(
        'name' => 'Vimeo',
        'docs' => 'https://developer.vimeo.com/',
      ),
      'giphy' => array(
        'name' => 'Giphy',
        'docs' => 'https://developers.giphy.com/docs/',
      ),
      'unsplash' => array(
        'name' => 'Unsplash',
        'docs' => 'https://unsplash.com/developers',
      ),
      'flickr' => array(
        'name' => 'Flickr',
        'docs' => 'https://www.flickr.com/services/developer/api/',
      ),
      'pixabay' => array(
        'name' => 'Pixabay',
        'docs' => 'https://pixabay.com/api/docs/',
      ),
    );
  }

}
