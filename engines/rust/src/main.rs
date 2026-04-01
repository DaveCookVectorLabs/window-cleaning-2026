mod engine;
mod models;

use actix_web::{web, App, HttpServer, HttpResponse, middleware};
use models::CalculateRequest;

async fn calculate_handler(body: web::Json<CalculateRequest>) -> HttpResponse {
    match engine::calculate(&body) {
        Ok(response) => HttpResponse::Ok().json(response),
        Err(msg) => HttpResponse::BadRequest().json(serde_json::json!({"error": msg})),
    }
}

async fn health() -> HttpResponse {
    HttpResponse::Ok().json(serde_json::json!({"status": "ok", "engine": "rust"}))
}

#[actix_web::main]
async fn main() -> std::io::Result<()> {
    println!("Rust engine listening on 0.0.0.0:8001");
    HttpServer::new(|| {
        App::new()
            .wrap(middleware::Logger::default())
            .route("/calculate", web::post().to(calculate_handler))
            .route("/health", web::get().to(health))
    })
    .bind("0.0.0.0:8001")?
    .run()
    .await
}
