pipeline {
    agent any  
    stages {
        stage("test") {
            steps {
                echo "hello world"
            }
        }
        stage("build") {
            steps {
                script {
                    bat 'docker --version'
                   // bat "docker-compose up -d --build"
                }
            }
        }
        stage("deploy to Kubernetes") {
            steps {
                withCredentials([file(credentialsId: 'testkubernate', variable: 'KUBECONFIG')]) {
                    script {
                        // Déployer sur Kubernetes
                        bat "kubectl apply -f kubernetes/bd-deployer.yaml --kubeconfig=${KUBECONFIG} --validate=false"
                        bat "kubectl apply -f kubernetes/bd-service.yaml --kubeconfig=${KUBECONFIG} --validate=false"
                        bat "kubectl apply -f kubernetes/php-deployer.yaml --kubeconfig=${KUBECONFIG} --validate=false"
                        bat "kubectl apply -f kubernetes/php-service.yaml --kubeconfig=${KUBECONFIG} --validate=false"
                    }
                }
            }
        }
    }
   
}
