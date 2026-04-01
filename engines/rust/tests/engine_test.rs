use actix_web::{test, web, App};
use serde_json::json;

// Import from the crate
use window_cleaning_engine::engine;
use window_cleaning_engine::models::CalculateRequest;

async fn calculate_handler(body: web::Json<CalculateRequest>) -> actix_web::HttpResponse {
    match engine::calculate(&body) {
        Ok(response) => actix_web::HttpResponse::Ok().json(response),
        Err(msg) => actix_web::HttpResponse::BadRequest().json(json!({"error": msg})),
    }
}

async fn health() -> actix_web::HttpResponse {
    actix_web::HttpResponse::Ok().json(json!({"status": "ok", "engine": "rust"}))
}

fn base_payload() -> serde_json::Value {
    json!({
        "window_count": 10,
        "window_type": "standard_single_pane",
        "access_method": "ground_level",
        "service_type": "both",
        "frequency": "one_time",
        "labour_rate": 22.00,
        "margin_pct": 35.0
    })
}

#[actix_web::test]
async fn test_health() {
    let app = test::init_service(
        App::new().route("/health", web::get().to(health))
    ).await;
    let req = test::TestRequest::get().uri("/health").to_request();
    let resp: serde_json::Value = test::call_and_read_body_json(&app, req).await;
    assert_eq!(resp["status"], "ok");
    assert_eq!(resp["engine"], "rust");
}

#[actix_web::test]
async fn test_basic_calculation() {
    let app = test::init_service(
        App::new().route("/calculate", web::post().to(calculate_handler))
    ).await;
    let req = test::TestRequest::post()
        .uri("/calculate")
        .set_json(&base_payload())
        .to_request();
    let resp: serde_json::Value = test::call_and_read_body_json(&app, req).await;
    assert_eq!(resp["labour_cost"], 14.67);
    assert_eq!(resp["materials_cost"], 1.17);
    assert_eq!(resp["subtotal"], 15.84);
    assert_eq!(resp["margin_amount"], 5.54);
    assert_eq!(resp["final_price"], 21.38);
    assert_eq!(resp["per_window_cost"], 2.14);
}

#[actix_web::test]
async fn test_all_window_types() {
    let app = test::init_service(
        App::new().route("/calculate", web::post().to(calculate_handler))
    ).await;

    let types = vec![
        ("standard_single_pane", 4.0),
        ("double_pane", 5.0),
        ("floor_to_ceiling", 8.0),
        ("storefront", 6.0),
        ("specialty", 12.0),
    ];

    for (wt, base_min) in types {
        let mut payload = base_payload();
        payload["window_type"] = json!(wt);
        payload["window_count"] = json!(1);

        let req = test::TestRequest::post()
            .uri("/calculate")
            .set_json(&payload)
            .to_request();
        let resp: serde_json::Value = test::call_and_read_body_json(&app, req).await;

        let labour = (base_min / 60.0) * 22.0;
        let materials = labour * 0.08;
        let subtotal = labour + materials;
        let margin = subtotal * 0.35;
        let expected = ((subtotal + margin) * 100.0).round() / 100.0;
        assert_eq!(resp["final_price"], expected, "Mismatch for {}", wt);
    }
}

#[actix_web::test]
async fn test_all_access_methods() {
    let app = test::init_service(
        App::new().route("/calculate", web::post().to(calculate_handler))
    ).await;

    let methods = vec![
        ("ground_level", 1.0),
        ("ladder", 1.4),
        ("boom_lift", 2.2),
        ("rope_access", 3.0),
        ("swing_stage", 3.5),
    ];

    for (am, mult) in methods {
        let mut payload = base_payload();
        payload["access_method"] = json!(am);
        payload["window_count"] = json!(1);

        let req = test::TestRequest::post()
            .uri("/calculate")
            .set_json(&payload)
            .to_request();
        let resp: serde_json::Value = test::call_and_read_body_json(&app, req).await;

        let labour = (4.0 * mult / 60.0) * 22.0;
        let materials = labour * 0.08;
        let subtotal = labour + materials;
        let margin = subtotal * 0.35;
        let expected = ((subtotal + margin) * 100.0).round() / 100.0;
        assert_eq!(resp["final_price"], expected, "Mismatch for {}", am);
    }
}

#[actix_web::test]
async fn test_all_frequencies() {
    let app = test::init_service(
        App::new().route("/calculate", web::post().to(calculate_handler))
    ).await;

    let freqs = vec![
        ("one_time", 1.0),
        ("quarterly", 0.90),
        ("monthly", 0.80),
        ("weekly", 0.70),
    ];

    for (freq, disc) in freqs {
        let mut payload = base_payload();
        payload["frequency"] = json!(freq);
        payload["window_count"] = json!(1);

        let req = test::TestRequest::post()
            .uri("/calculate")
            .set_json(&payload)
            .to_request();
        let resp: serde_json::Value = test::call_and_read_body_json(&app, req).await;

        let labour = (4.0 / 60.0) * 22.0 * disc;
        let materials = labour * 0.08;
        let subtotal = labour + materials;
        let margin = subtotal * 0.35;
        let expected = ((subtotal + margin) * 100.0).round() / 100.0;
        assert_eq!(resp["final_price"], expected, "Mismatch for {}", freq);
    }
}

#[actix_web::test]
async fn test_invalid_window_type() {
    let app = test::init_service(
        App::new().route("/calculate", web::post().to(calculate_handler))
    ).await;

    let mut payload = base_payload();
    payload["window_type"] = json!("nonexistent");

    let req = test::TestRequest::post()
        .uri("/calculate")
        .set_json(&payload)
        .to_request();
    let resp = test::call_service(&app, req).await;
    assert_eq!(resp.status(), 400);
}
